<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AdminLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'admin_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'admin_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'item' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'item_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'change_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('admin_logs');
    }
    
    public function down()
    {
        $this->forge->dropTable('admin_logs');
    }
}
