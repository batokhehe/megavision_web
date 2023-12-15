<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('employees')->insertBatch($this->generateData());
    }

    private function generateData(): array
    {
        return [
            [
                'id' => 'S003',
                'name' => 'Boris Baker',
                'email' => 'boris.baker@office.com',
                'phone' => '+62 866-541-918',
                'office_id' => 1
            ],
            [
                'id' => 'S010',
                'name' => 'Jane Bell',
                'email' => 'jane.bell@office.com',
                'phone' => '+62 898-9997-62059',
                'office_id' => 1
            ],
            [
                'id' => 'S009',
                'name' => 'Livia Roberts',
                'email' => 'livia.roberts@office.com',
                'phone' => '+62 889-648-234',
                'office_id' => 2
            ],
            [
                'id' => 'S001',
                'name' => 'Martin Lloyd',
                'email' => 'martin.lloyd@office.com',
                'phone' => '+62 862-5031-53370',
                'office_id' => 1
            ],
            [
                'id' => 'S002',
                'name' => 'John Hobson',
                'email' => 'john.hobson@office.com',
                'phone' => '+62 813-105-750',
                'office_id' => 1
            ],
            [
                'id' => 'S006',
                'name' => 'Doug Callan',
                'email' => 'doug.callan@office.com',
                'phone' => '+62 881-180-462',
                'office_id' => 3
            ],
            [
                'id' => 'S007',
                'name' => 'Elisabeth Nanton',
                'email' => 'elisabeth.nanton@office.com',
                'phone' => '+62 853-3431-15623',
                'office_id' => 2
            ],
            [
                'id' => 'S004',
                'name' => 'Margot Sinclair',
                'email' => 'margot.sinclair@office.com',
                'phone' => '+62 898-1644-343',
                'office_id' => 3
            ],
            [
                'id' => 'S005',
                'name' => 'Alessandra Fall',
                'email' => 'alessandra.fall@office.com',
                'phone' => '+62 828-806-332',
                'office_id' => 3
            ],
            [
                'id' => 'S008',
                'name' => 'Bob Carter',
                'email' => 'bob.carter@office.com',
                'phone' => '+62 853-255-099',
                'office_id' => 2
            ]
        ];
    }
}
