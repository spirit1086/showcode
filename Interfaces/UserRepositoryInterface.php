<?php
namespace App\Modules\Auth\Interfaces;

use App\Modules\Auth\Dto\{BaseUserDto, FilterUserDto};
use App\Modules\Classroom\Dto\ChildClassroomDto;
use App\Modules\Auth\Models\{Role,User};
use App\Modules\Notification\Dto\SmsDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
  public function items(FilterUserDto $filterUserDto): LengthAwarePaginator;
  public function item(int $id): ?User;
  public function store(BaseUserDto $userDto): User;
  public function changeFastCode(User $user, string $code): void;
  public function findRole(string $alias): Role;
  public function findUserOfMobile(SmsDto $dto): ?User;
  public function findUserOfIin(int $iin): ?User;
  public function usersOfRoleAlias(string $role_alias, int $school_id): Collection;
  public function childsOfClassroomParallel(ChildClassroomDto $childClassroomDto): Collection;
}
