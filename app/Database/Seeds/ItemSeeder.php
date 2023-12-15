<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('items')->insertBatch($this->generateData());
    }

    private function generateData(): array
    {
        return [
            [
                'id' => '1',
                'name' => 'Item A',
                'amount' => 200000,
            ],
            [
                'id' => '2',
                'name' => 'Item B',
                'amount' => 500000,
            ],
        ];
    }
}
