<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableOrder extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => false,              
                'null' => false,              
            ],
            'item_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'employee_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'client_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'order_date' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
