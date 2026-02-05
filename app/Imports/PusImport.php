<?php

namespace App\Imports;

use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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
                empty($row['name']) ||
                empty($row['number']) ||
                empty($row['state']) ||
                empty($row['zone']) ||
                empty($row['lga']) ||
                empty($row['ward'])
            ) {
                Log::warning('PU import skipped: missing required fields', $row->toArray());
                continue;
            }

            // -------------------------------
            // NORMALIZE VALUES
            // -------------------------------
            $stateName = Str::title(trim($row['state']));
            $zoneName  = Str::title(trim($row['zone']));
            $lgaName   = Str::title(trim($row['lga']));
            $wardName  = Str::title(trim($row['ward']));
            $puName    = Str::title(trim($row['name']));
            $puNumber  = trim($row['number']);

            // -------------------------------
            // FETCH STATE
            // -------------------------------
            $state = State::where('name', $stateName)->first();

            if (! $state) {
                Log::warning("PU import skipped: State not found ({$stateName})", $row->toArray());
                continue;
            }

            // -------------------------------
            // FETCH ZONE (SCOPED TO STATE)
            // -------------------------------
            $zone = Zone::where('name', $zoneName)
                ->where('state_id', $state->id)
                ->first();

            if (! $zone) {
                Log::warning("PU import skipped: Zone not found ({$zoneName})", $row->toArray());
                continue;
            }

            // -------------------------------
            // FETCH LGA (SCOPED TO ZONE)
            // -------------------------------
            $lga = Lga::where('name', $lgaName)
                ->where('zone_id', $zone->id)
                ->first();

            if (! $lga) {
                Log::warning("PU import skipped: LGA not found ({$lgaName})", $row->toArray());
                continue;
            }

            // -------------------------------
            // FETCH WARD (SCOPED TO LGA)
            // -------------------------------
            $ward = Ward::where('name', $wardName)
                ->where('lga_id', $lga->id)
                ->first();

            if (! $ward) {
                Log::warning("PU import skipped: Ward not found ({$wardName})", $row->toArray());
                continue;
            }

            // -------------------------------
            // CREATE OR UPDATE PU
            // -------------------------------
            $ward->pus()->firstOrCreate(
                [
                    'number' => $puNumber,
                ],
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
