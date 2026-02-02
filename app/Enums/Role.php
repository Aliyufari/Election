<?php

namespace App\Enums;

enum Role: string
{
    case SUPER = 'super';
    case ADMIN = 'admin';

    case STATE_COORDINATOR = 'state_coordinator';
    case ZONAL_COORDINATOR = 'zonal_coordinator';
    case LGA_COORDINATOR = 'lga_coordinator';
    case WARD_COORDINATOR = 'ward_coordinator';

    public static function coordinatorRoles(): array
    {
        return collect(self::cases())
            ->reject(
                fn(self $role) =>
                in_array($role, [self::SUPER, self::ADMIN], true)
            )
            ->map(fn(self $role) => $role->value)
            ->values()
            ->toArray();
    }
}
