<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudiosTable extends Migration
{
    public function up()
    {
        // Tabel Master Studio
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_studio' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug_studio' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('studios');

        // Tabel Pivot anime_studios (Penghubung)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'anime_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'studio_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('anime_id', 'animes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('studio_id', 'studios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('anime_studios');
    }

    public function down()
    {
        $this->forge->dropTable('anime_studios');
        $this->forge->dropTable('studios');
    }
}
