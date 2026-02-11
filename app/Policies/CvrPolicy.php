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
        if ($user->hasAnyRole([
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
        return $user->hasAnyRole($this->coordinatorRoles());
    }

    /**
     * View a single CVR
     */
    public function view(User $user, Cvr $cvr): bool
    {
        $pu = $cvr->pu;

        return match (true) {
            $user->isStateCoordinator() =>
            $pu->state_id === $user->state_id,

            $user->isZonalCoordinator() =>
            $pu->zone_id === $user->zone_id,

            $user->isLgaCoordinator() =>
            $pu->lga_id === $user->lga_id,

            $user->isWardCoordinator() =>
            $pu->ward_id === $user->ward_id,

            default => false,
        };
    }

    /**
     * Create CVR
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->coordinatorRoles());
    }

    /**
     * Update CVR
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
        return $user->isStateCoordinator()
            && $cvr->pu->state_id === $user->state_id;
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
