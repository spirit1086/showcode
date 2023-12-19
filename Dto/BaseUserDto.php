<?php


namespace App\Modules\Auth\Dto;


use App\Traits\SecureParams;

abstract class BaseUserDto
{
    use SecureParams;

    public const USER_INTERFACE_PARENT = 'parent';
    public const USER_INTERFACE_CHILD = 'child';
    public const USER_INTERFACE_DASHBOARD = 'dashboard';

    private ?int $id;
    private string $lastname;
    private string $firstname;
    private string $middlename;
    private array $iin;
    private string $photo;
    private string $mobile;
    private array $roles;
    private string $fast_code;
    private string $save_interface;

    public function __construct(array $request) {
        if (isset($request['id'])) {
            $this->id = (int)SecureParams::filter($request['id']);
        } else {
            $this->id = null;
        }
        $this->lastname = SecureParams::filter($request['lastname']);
        $this->firstname = SecureParams::filter($request['firstname']);
        $this->middlename = SecureParams::filter($request['middlename']);
        $this->iin = SecureParams::filter($request['iin']);
        if (isset($request['photo'])) {
            $this->photo = SecureParams::filter($request['photo']);
        }
        $mobile = SecureParams::filter($request['mobile']);
        $this->mobile = SecureParams::rmMobilePlus($mobile);
        if (isset($request['roles'])) {
            $this->roles = SecureParams::filter($request['roles']);
        }
        $this->save_interface = SecureParams::filter($request['save_interface']);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
