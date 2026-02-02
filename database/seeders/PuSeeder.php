<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\State;
use App\Models\Lga;
use App\Models\Ward;

class PuSeeder extends Seeder
{
    public function run()
    {
        $stateName = 'Bauchi';
        $state = State::where('name', $stateName)->first();

        if (!$state) {
            $this->command->error("❌ State {$stateName} not found");
            return;
        }

        $lga = Lga::where('name', 'Bauchi')->where('state_id', $state->id)->first();
        if (!$lga) {
            $this->command->error("❌ LGA Bauchi not found");
            return;
        }

        // Mapping based on your specific Ward list
        $data = [
            'Birshi'     => [
                ['number' => '05/01/07/002', 'name' => 'Kofar Sarkin Birshi'],
                ['number' => '05/01/07/007', 'name' => 'Kofar Gidan Shuaibu'],
            ],
            'Dandango'   => [
                ['number' => '05/01/06/001', 'name' => 'Dandango Primary School'],
                ['number' => '05/01/06/004', 'name' => 'Kofar Gidan Sarkin Dandango'],
            ],
            'Dan’iya'    => [
                ['number' => '05/01/11/001', 'name' => 'Kofar Fada Dan Iya'],
                ['number' => '05/01/11/014', 'name' => 'Kofar Gidan Dan’iya'],
            ],
            'Dawaki'     => [
                ['number' => '05/01/12/001', 'name' => 'Dawaki Primary School'],
                ['number' => '05/01/12/008', 'name' => 'Kofar Gidan Sarkin Dawaki'],
            ],
            'Galambi'    => [
                ['number' => '05/01/10/001', 'name' => 'Galambi Primary School'],
                ['number' => '05/01/10/012', 'name' => 'Kofar Fada Galambi'],
            ],
            'Kangal'     => [
                ['number' => '05/01/09/001', 'name' => 'Kangal Primary School'],
                ['number' => '05/01/09/010', 'name' => 'Kofar Gidan Jauro Kangal'],
            ],
            'Majidadi A' => [
                ['number' => '05/01/01/004', 'name' => 'Kofar Iyan Gari'],
                ['number' => '05/01/01/011', 'name' => 'Kofar Jabosa'],
            ],
            'Majidadi B' => [
                ['number' => '05/01/02/001', 'name' => 'Kofar Bauchin Bauchi'],
                ['number' => '05/01/02/015', 'name' => 'Kofar Gidan Majidadi'],
            ],
            'Makama B'   => [
                ['number' => '05/01/03/001', 'name' => 'Gwalaga Primary School'],
                ['number' => '05/01/03/061', 'name' => 'Babasidi Primary School'],
            ],
            'Mun'        => [
                ['number' => '05/01/05/001', 'name' => 'Mun Primary School'],
                ['number' => '05/01/05/008', 'name' => 'Kofar Gidan Sarkin Mun'],
            ],
            'Zungur'     => [
                ['number' => '05/01/04/001', 'name' => 'Liman Katagum Pri. Sch.'],
                ['number' => '05/01/04/009', 'name' => 'Kofar Fada Zungur'],
            ],
        ];

        foreach ($data as $wardName => $pus) {
            // Precise ward matching
            $ward = Ward::where('name', $wardName)
                ->where('lga_id', $lga->id)
                ->first();

            if (!$ward) {
                $this->command->warn("⚠ Ward {$wardName} not found in Bauchi LGA, skipping.");
                continue;
            }

            foreach ($pus as $puData) {
                DB::table('pus')->updateOrInsert([
                    'number' => $puData['number'],
                    'lga_id' => $lga->id,
                    'ward_id' => $ward->id,
                    'state_id' => $state->id,
                ], [
                    'name' => $puData['name'],
                    'zone_id' => $lga->zone_id,
                    'description' => 'Official PU',
                    'registration' => 0,
                    'accreditation' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info("✅ PU {$puData['name']} added to Ward: {$wardName}");
            }
        }
    }
}
