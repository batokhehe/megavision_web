<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OfficeSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('offices')->insertBatch($this->generateData());
    }

    private function generateData(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Jakarta'
            ],
            [
                'id' => 2,
                'name' => 'Bandung'
            ],
            [
                'id' => 3,
                'name' => 'Bogor'
            ],
        ];
    }
}
