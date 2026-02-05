<?php

namespace App\Imports;

use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PusImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // -------------------------------
            // BASIC VALIDATION
            // -------------------------------
            if (
                empty($row['state']) ||
                empty($row['zone']) ||
                empty($row['lga']) ||
                empty($row['ra']) ||
                empty($row['pu']) ||
                empty($row['delim'])
            ) {
                continue;
            }

            // -------------------------------
            // NORMALIZE VALUES
            // -------------------------------
            $stateName = Str::title(trim($row['state']));
            $zoneName  = Str::title(trim($row['zone']));
            $lgaName   = Str::title(trim($row['lga']));
            $wardName  = Str::title(trim($row['ra']));
            $puName    = Str::title(trim($row['pu']));
            $puNumber  = trim($row['delim']);

            // -------------------------------
            // STATE (CREATE OR UPDATE)
            // -------------------------------
            $state = State::updateOrCreate(
                ['name' => $stateName],
                ['name' => $stateName]
            );

            // -------------------------------
            // ZONE (SCOPED TO STATE)
            // -------------------------------
            $zone = $state->zones()->updateOrCreate(
                ['name' => $zoneName],
                [
                    'name' => $zoneName,
                    'state_id' => $state->id
                ]
            );

            // -------------------------------
            // LGA (SCOPED TO ZONE)
            // -------------------------------
            $lga = $zone->lgas()->updateOrCreate(
                ['name' => $lgaName],
                [
                    'name' => $lgaName,
                    'state_id' => $state->id,
                    'zone_id' => $zone->id,
                ]
            );

            // -------------------------------
            // WARD (SCOPED TO LGA)
            // -------------------------------
            $ward = $lga->wards()->updateOrCreate(
                ['name' => $wardName],
                [
                    'name' => $wardName,
                    'state_id' => $state->id,
                    'zone_id' => $zone->id,
                    'lga_id' => $lga->id,
                ]
            );

            // -------------------------------
            // PU (SCOPED TO WARD)
            // -------------------------------
            $ward->pus()->updateOrCreate(
                ['number' => $puNumber],
                [
                    'name'     => $puName,
                    'state_id' => $state->id,
                    'zone_id'  => $zone->id,
                    'lga_id'   => $lga->id,
                    'ward_id'  => $ward->id,
                ]
            );
        }
    }
}
