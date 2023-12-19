<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Interfaces\UserServiceInterface;
use App\Modules\Auth\Requests\CreateFastCodeRequest;
use App\Modules\Auth\Requests\UserValidate;
use App\Modules\Auth\Resources\UserCollection;
use App\Modules\Auth\Resources\UserResource;
use App\Modules\Notification\Dto\SmsDto;
use App\Traits\DatesTrait;
use App\Traits\SaveUserInterface;
use Illuminate\Http\Request;
use App\Modules\Auth\Dto\FilterUserDto;

class UserController extends Controller
{
   use SaveUserInterface, DatesTrait;
   private UserServiceInterface $userService;

   public function __construct(UserServiceInterface $userService)
   {
      $this->userService = $userService;
   }

   public function users(Request $request): UserCollection
   {
       $filterUserDto = new FilterUserDto($request->all());
       $users = $this->userService->getList($filterUserDto);
       return new UserCollection($users);
   }

   public function user(int $id): UserResource
   {
      $user = $this->userService->getItem($id);
      return new UserResource($user);
   }

   public function userStore(UserValidate $request, ?int $id = null): UserResource
   {
        $user = $this->setUser($request->all(),$id);
        return new UserResource($user);
   }

   private function setUser($request, $id)
   {
       if ($id) {
           $request['id'] = $id;
           $this->userService->getItem($id);
       }
       $dto = SaveUserInterface::dto($request);
       return $this->userService->setItem($dto);
   }

   public function addToUserFastCode(CreateFastCodeRequest $request)
   {
       $smsDto = new SmsDto(['mobile' => $request->input('mobile'),'is_generate_sms' => true]);
       $user = $this->userService->findUserAccount($smsDto);
       $user_sms = $this->userService->findSms($smsDto);
       $tmp_token = $request->input('tmp_token');
       $validateTimeSms = DatesTrait::diffs(date('Y-m-d H:i:s'),$user_sms->tmp_token_created);
       if ($user_sms->tmp_token != $tmp_token || $validateTimeSms > 60) {
         return response()->json(['fast_code_update' => false]);
       }
       if (!$user ) {
           $user = $this->setUser($request->input('user'),null);
       }
       $this->userService->userChangeFastCode($user, $request->input('code'));
   }

   public function findIIn(Request $request)
   {
       $response = $this->userService->findIin($request->input('iin'));
       $is_have_iin = $response ? true : false;
       return new UserResource(['is_have_iin' => $is_have_iin]);
   }

   public function usersOfRole(Request $request)
   {
       $users = $this->userService->findUsersOfRoleAlias($request->input('role_alias'),$request->input('school_id'));
       return new UserCollection($users);
   }
}
