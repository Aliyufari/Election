<?php

namespace App\Policies;

use App\Models\Cvr;
use App\Models\User;
use App\Enums\Role;
use App\Traits\HandleRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class CvrPolicy
{
    use HandlesAuthorization, HandleRoles;

    /**
     * Super & Admin can do everything
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($this->hasAnyRoleUser($user, [
            Role::SUPER,
            Role::ADMIN,
        ])) {
            return true;
        }

        return null;
    }

    /**
     * View CVR list
     */
    public function viewAny(User $user): bool
    {
        return $this->hasAnyRoleUser($user, $this->coordinatorRoles());
    }

    /**
     * View a single CVR
     */
    public function view(User $user, Cvr $cvr): bool
    {
        $pu = $cvr->pu;

        return match (true) {
            $this->isStateCoordinatorUser($user) =>
            $pu->state_id === $user->state_id,

            $this->isZonalCoordinatorUser($user) =>
            $pu->zone_id === $user->zone_id,

            $this->isLgaCoordinatorUser($user) =>
            $pu->lga_id === $user->lga_id,

            $this->isWardCoordinatorUser($user) =>
            $pu->ward_id === $user->ward_id,

            default => false,
        };
    }

    /**
     * Create CVR
     */
    public function create(User $user): bool
    {
        return $this->hasAnyRoleUser($user, $this->coordinatorRoles());
    }

    /**
     * Update CVR
     * (Super/Admin already allowed via before())
     */
    public function update(User $user, Cvr $cvr): bool
    {
        return false;
    }

    /**
     * Delete CVR
     */
    public function delete(User $user, Cvr $cvr): bool
    {
        if ($this->isStateCoordinatorUser($user)) {
            return $cvr->pu->state_id === $user->state_id;
        }

        return false;
    }

    /**
     * Coordinator roles helper
     */
    private function coordinatorRoles(): array
    {
        return [
            Role::STATE_COORDINATOR,
            Role::ZONAL_COORDINATOR,
            Role::LGA_COORDINATOR,
            Role::WARD_COORDINATOR,
        ];
    }
}
