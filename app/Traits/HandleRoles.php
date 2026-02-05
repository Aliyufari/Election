<?php

namespace App\Traits;

use App\Enums\Role;

trait HandleRoles
{
    protected function roleName(): ?string
    {
        if (! $this->relationLoaded('role')) {
            $this->load('role');
        }

        return $this->role?->name;
    }

    /* =======================
     |  Core role checks
     ======================= */

    public function hasRole(string|Role $role): bool
    {
        $roleName = $role instanceof Role
            ? $role->value
            : $role;

        return $this->roleName() === $roleName;
    }

    public function hasAnyRole(array $roles): bool
    {
        $roleNames = array_map(
            fn($role) => $role instanceof Role ? $role->value : $role,
            $roles
        );

        return in_array($this->roleName(), $roleNames, true);
    }

    /* =======================
     |  Semantic helpers
     ======================= */

    public function isSuper(): bool
    {
        return $this->hasRole(Role::SUPER);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ADMIN);
    }

    public function isStateCoordinator(): bool
    {
        return $this->hasRole(Role::STATE_COORDINATOR);
    }

    public function isZonalCoordinator(): bool
    {
        return $this->hasRole(Role::ZONAL_COORDINATOR);
    }

    public function isLgaCoordinator(): bool
    {
        return $this->hasRole(Role::LGA_COORDINATOR);
    }

    public function isWardCoordinator(): bool
    {
        return $this->hasRole(Role::WARD_COORDINATOR);
    }
}
