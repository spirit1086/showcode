<?php


namespace App\Modules\Auth\Services;


use App\Modules\Auth\Dto\BaseUserDto;
use App\Modules\Classroom\Dto\ChildClassroomDto;
use App\Modules\Auth\Dto\FilterUserDto;
use App\Modules\Auth\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Interfaces\UserServiceInterface;
use App\Modules\Auth\Models\Iin;
use App\Modules\Auth\Models\Role;
use App\Modules\Auth\Models\RoleUser;
use App\Modules\Auth\Models\SmsUser;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Models\UserSubject;
use App\Modules\Notification\Dto\SmsDto;
use App\Modules\Notification\Interfaces\NotificationRepositoryInterface;
use App\Traits\SecureParams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService implements UserServiceInterface
{
   use SecureParams;
   private UserRepositoryInterface $userRepository;
   private NotificationRepositoryInterface $notificationRepository;

   public function __construct(UserRepositoryInterface $userRepository,NotificationRepositoryInterface $notificationRepository)
   {
       $this->userRepository = $userRepository;
       $this->notificationRepository = $notificationRepository;
   }

   public function getList(FilterUserDto $filterUserDto): LengthAwarePaginator
   {
       return $this->userRepository->items($filterUserDto);
   }

   public function getItem(int $id): ?User
   {
      return $this->userRepository->item($id);
   }

   public function setItem(BaseUserDto $userDto): User
   {
       try {
           DB::beginTransaction();
           $data = $userDto->toArray();
           $user = $this->userRepository->store($userDto);
           $iin = [];
           for ($i = 0; $i < count($data['iin']); $i++) {
               $iin[] = new Iin(['user_iin' => $data['iin'][$i]]);
           }
           if (!empty($iin)) {
               $user->iins()->delete();
               $user->iins()->saveMany($iin);
           }
           if ($data['save_interface'] == BaseUserDto::USER_INTERFACE_DASHBOARD) {
               $subjects = [];
               for ($i = 0; $i < count($data['subjects']); $i++) {
                   $subjects[] = new UserSubject(['subject_id' => $data['subjects'][$i]]);
               }
               if (!empty($subjects)) {
                   $user->userSubject()->delete();
                   $user->userSubject()->saveMany($subjects);
               }
               $roles = [];
               for ($i = 0; $i < count($data['roles']); $i++) {
                  $roles[] = new RoleUser(['role_id' => $data['roles'][$i]]);
               }
            } else {
               $roleOfUser = $this->userRepository->findRole(Role::ROLE_USER);
               $roles[] = new RoleUser(['role_id' => $roleOfUser->id]);
           }
           if (!empty($roles)) {
               $user->RoleUser()->delete();
               $user->RoleUser()->saveMany($roles);
           }
           DB::commit();
           return $this->getItem($user->id);
       } catch (HttpException $exception) {
           DB::rollBack();
           throw new HttpResponseException(response()->json(['error_message' => $exception->getMessage()]));
       }
   }

   public function userChangeFastCode(User $user, string $code): void
   {
       try {
           DB::beginTransaction();
           $this->userRepository->changeFastCode($user, $code);
           DB::commit();
       } catch (HttpException $exception) {
           DB::rollBack();
           throw new HttpResponseException(response()->json(['error_message' => $exception->getMessage()]));
       }
   }

   public function findUserAccount(SmsDto $dto): ?User
   {
       return $this->userRepository->findUserOfMobile($dto);
   }

   public function findSms(SmsDto $smsDto): SmsUser
   {
       return $this->notificationRepository->findMobileSms($smsDto);
   }

   public function findIin(int $iin): ?User
   {
     return $this->userRepository->findUserOfIin($iin);
   }

   public function findUsersOfRoleAlias(string $role_alias, int $school_id): Collection
   {
       return $this->userRepository->usersOfRoleAlias($role_alias, $school_id);
   }

   public function findChildsOfClassroomParallel(ChildClassroomDto $childClassroomDto): Collection
   {
       return $this->userRepository->childsOfClassroomParallel($childClassroomDto);
   }
}
