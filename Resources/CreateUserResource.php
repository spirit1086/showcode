<?php

namespace App\Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateUserResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /** @var int */
            'id' => $this->id,
            /** @var string */
            'lastname' => $this->lastname,
            /** @var string */
            'firstname' => $this->firstname,
            /** @var string */
            'middlename' => $this->middlenames,
            /** @var int */
            'city_id' => $this->city_id,
            /** @var string */
            'street' => $this->street,
            /** @var int */
            'house_number' => $this->house_number,
            /** @var int */
            'apt' => $this->apt,
            /** @var int */
            'school_id' => $this->school_id,
            /** @var int */
            'class' => $this->class,
            /** @var string */
            'letter' => $this->letter,
            /** @var string */
            'birthday' => $this->birthday,
            /** @var string */
            'photo' => $this->photo,
            /** @var string */
            'mobile' => $this->mobile,
            /** @var int */
            'relation_id' => $this->relation_id,
            /** @var int */
            'gender_id' => $this->gender_id,
            /** @var string */
            'last_login' => $this->last_login,
            /** @var int */
            'login_type' => $this->login_type,
            /** @var int */
            'is_confirmed' => $this->is_confirmed,
            /** @var array{RolesOfUserCollection} */
            'roles_of_user' => RolesOfUserCollection::collection($this->rolesOfUser),
            /** @var array{SubjectsCollection} */
            'subjects' => SubjectsCollection::collection($this->subjects),
            /** @var array{IinCollection} */
            'iins' => IinCollection::collection($this->iins)
        ];
    }
}
