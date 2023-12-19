<?php


namespace App\Modules\Auth\Interfaces;


use App\Modules\Auth\Models\SmsUser;
use App\Modules\Notification\Dto\SmsDto;
use App\Modules\Auth\Dto\{BaseUserDto, FilterUserDto};
use App\Modules\Classroom\Dto\ChildClassroomDto;
use App\Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
   public function getList(FilterUserDto $filterUserDto): LengthAwarePaginator;
   public function getItem(int $id): ?User;
   public function setItem(BaseUserDto $userDto): User;
   public function userChangeFastCode(User $user, string $code): void;
   public function findUserAccount(SmsDto $dto): ?User;
   public function findSms(SmsDto $smsDto): SmsUser;
   public function findIin(int $iin): ?User;
   public function findUsersOfRoleAlias(string $role_alias, int $school_id): Collection;
   public function findChildsOfClassroomParallel(ChildClassroomDto $childClassroomDto): Collection;
}
