<?php
namespace App\Modules\Auth\Repositories;

use App\Modules\Auth\Dto\BaseUserDto;
use App\Modules\Classroom\Dto\ChildClassroomDto;
use App\Modules\Auth\Dto\FilterUserDto;
use App\Modules\Auth\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Models\Role;
use App\Modules\Auth\Models\User;
use App\Modules\Notification\Dto\SmsDto;
use App\Traits\SecureParams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
  use SecureParams;

  public function items(FilterUserDto $filterUserDto): LengthAwarePaginator
  {
      $users = new User();
      if ($filterUserDto->getId()) {
          $users = $users->where('id','=',$filterUserDto->getId());
      }
      if ($filterUserDto->getFio()) {
          $users = $users->whereRaw('concat(lastname,firstname,middlename) LIKE "%'. $filterUserDto->getFio() .'%"');
      }
      if ($filterUserDto->getIin()) {
          $users = $users->where('iin', '=' , $filterUserDto->getIin());
      }
      if ($filterUserDto->getMobile()) {
          $users = $users->where('mobile', '=' , $filterUserDto->getMobile());
      }
      if ($filterUserDto->getRoles()) {
          $users = $users->withWhereHas('rolesOfUser', function ($query) use ($filterUserDto) {
              $query->whereIn('id',$filterUserDto->getRoles())->select('id','title');
          });
      }
      return $users->with(['rolesOfUser:id,title','subjects:id,title','iins:id,user_iin,user_id'])->orderByDesc('users.id')->paginate($filterUserDto->getPerPage());
  }

  public function item(int $id): ?User
  {
      return User::with(['rolesOfUser:id,title','subjects:id,title','iins:id,user_iin,user_id'])->findOrFail($id);
  }

  public function store(BaseUserDto $userDto): User
  {
      return User::updateOrCreate(['id' => $userDto->getId()],$userDto->toArray());
  }

  public function changeFastCode(User $user, string $code): void
  {
      $user->password = Hash::make($code . date('YmdHis',strtotime($user->created_at)));
      $user->fast_code = $code;
      $user->save();
  }

  public function findRole(string $alias): Role
  {
      return Role::where('alias', '=', $alias)->first();
  }

  public function findUserOfMobile(SmsDto $dto): ?User
  {
      return User::where('mobile','=',$dto->getMobile())
                 ->select('id','mobile','fast_code','created_at')
                 ->first();
  }

  public function findUserOfIin(int $iin): ?User
  {
      return User::join('iins', function (JoinClause $join) use($iin) {
          $join->on('users.id', '=', 'iins.user_id')
                ->where('user_iin','=',$iin);
      })->select(DB::raw('users.*, iins.user_iin'))->firstOrFail();
  }

  public function usersOfRoleAlias(string $role_alias, int $school_id): Collection
  {
      return User::join('role_user',function (JoinClause $join){
                       $join->on('users.id','=','role_user.user_id');
                    })->join('roles',function (JoinClause $join) use ($role_alias){
                       $join->on('role_user.role_id','=','roles.id')
                            ->where('roles.alias','=',$role_alias);
                    })->where('users.school_id','=',$school_id)
                      ->select('users.id',DB::raw('CONCAT(users.lastname,\' \',users.firstname,\' \',users.middlename) as fio'))
                      ->orderByDesc('users.id')
                      ->get();
  }

  public function childsOfClassroomParallel(ChildClassroomDto $childClassroomDto): Collection
  {
      $role_alias = $childClassroomDto->getRoleAlias();
      return User::join('role_user',function (JoinClause $join){
                      $join->on('users.id','=','role_user.user_id');
                   })
                  ->join('roles',function (JoinClause $join) use ($role_alias){
                           $join->on('role_user.role_id','=','roles.id')
                                ->where('roles.alias','=',$role_alias);
                  })
               ->where('users.school_id','=',$childClassroomDto->getSchoolId())
               ->where('users.class','=',$childClassroomDto->getClass())
               ->where('users.letter','!=',$childClassroomDto->getLetter())
               ->whereNotNull('users.is_confirmed')
               ->where('users.save_interface','!=',BaseUserDto::USER_INTERFACE_PARENT)
               ->select('users.id',
                        'users.school_id',
                        'users.class',
                        'users.letter',
                        'users.is_confirmed',
                        DB::raw('CONCAT(users.lastname,\' \',users.firstname,\' \',users.middlename) as fio'))
               ->orderByDesc('users.class')
               ->get();
  }
}
