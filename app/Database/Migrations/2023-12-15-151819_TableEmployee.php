<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableEmployee extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 5                
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'office_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('employees');
    }

    public function down()
    {
        $this->forge->dropTable('employees');
    }
}
