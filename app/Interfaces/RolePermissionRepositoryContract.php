<?php namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RolePermissionRepositoryContract
{
    public function assignRolesToUser(array $roles): void;

    public function setUser(String $userId): Model;

    public function assignPermissionToRole(int $roleId, array $perms): void;

    public function removeRoleFromUser(array $roles): void;

    public function removePermissionFromRole(int $roleId, int $perms): void;

    public function getRolesByUser(): Collection;

    public function getPermissionByRole(int $roleId): Collection;
}