<?php namespace App\Repositories;

use App\Interfaces\RolePermissionRepositoryContract;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PermissionRoleRepository implements RolePermissionRepositoryContract
{
    public $userId;
    private $user;
    private $currentUser;
    private $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function setUser(String $userId): Model
    {
        $this->userId = $userId;
        $this->currentUser = $this->user->newQuery()->findOrFail($this->userId);
        return $this->currentUser;
    }

    public function assignRolesToUser(array $roles): void
    {
        try {
            $this->currentUser->roles()->sync($roles);
        } catch (\Exception $exception) {
        }
    }

    public function assignPermissionToRole(int $roleId, array $perms): void
    {
        try {
            $role = $this->role->newQuery()->findOrFail($roleId);
            $role->perms()->sync($perms);
        } catch (\Exception $exception) {
        }
    }

    public function removeRoleFromUser(array $roles): void
    {
        try {
            $this->currentUser->roles()->detach($roles);
        } catch (\Exception $exception) {
        }
    }

    public function removePermissionFromRole(int $roleId, int $perms): void
    {
        try {
            $role = $this->role->newQuery()->findOrFail($roleId);
            $role->perms()->detach($perms);
        } catch (\Exception $exception) {
        }
    }

    public function getRolesByUser(): Collection
    {
        $roles = $this->currentUser->roles;
        return $roles;
    }

    public function getPermissionByRole(int $roleId): Collection
    {
        $role = $this->role->newQuery()->findOrFail($roleId);
        return $role->perms;
    }
}