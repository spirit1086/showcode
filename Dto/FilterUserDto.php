<?php
namespace App\Modules\Auth\Dto;

use App\Traits\SecureParams;

class FilterUserDto
{
    private ?int $id;
    private ?string $fio;
    private ?string $mobile;
    private ?int $iin;
    private ?array $roles;
    private int $per_page;

    public function __construct(array $request)
    {
       $this->id = isset($request['id']) ? SecureParams::filter($request['id']) : null;
       $this->fio = isset($request['fio']) ? SecureParams::filter($request['fio']) : null;
       $this->mobile = isset($request['mobile']) ? SecureParams::filter($request['mobile']) : null;
       $this->iin = isset($request['iin']) ? SecureParams::filter($request['iin']) : null;
       $this->roles = isset($request['roles']) ? SecureParams::filter($request['roles']) : null;
       $this->per_page = isset($request['per_page']) ? SecureParams::filter($request['per_page']) : 15;
    }

    /**
     * @return string
     */
    public function getFio(): ?string
    {
        return $this->fio;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @return int
     */
    public function getIin(): ?int
    {
        return $this->iin;
    }

    /**
     * @return array
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->per_page;
    }
}
