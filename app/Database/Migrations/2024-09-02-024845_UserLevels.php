<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserLevel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'level' => [
                'type' => 'ENUM',
                'constraint' => ['Basic', 'Pro'],
                'default' => 'Basic',
            ],
            'coins' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
            ],
            'subscription_expiry' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_level');  // Pastikan nama tabelnya sesuai
    }

    public function down()
    {
        $this->forge->dropTable('user_level');  // Nama tabel harus konsisten
    }
}
