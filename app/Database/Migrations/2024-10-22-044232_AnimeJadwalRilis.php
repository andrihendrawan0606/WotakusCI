<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnimeJadwalRilis extends Migration
{
    public function up()
    {
        // Membuat tabel anime_jadwal_rilis
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'anime_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'hari_rilis' => [
                'type'       => 'ENUM',
                'constraint' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumaat', 'Sabtu', 'Minggu'],
                'null'       => false
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ]
        ]);

        // Set primary key
        $this->forge->addKey('id', true);

        // Set foreign key untuk anime_id yang terhubung ke tabel anime
        $this->forge->addForeignKey('anime_id', 'animes', 'id', 'CASCADE', 'CASCADE');

        // Membuat tabel
        $this->forge->createTable('anime_jadwal_rilis');
    }

    public function down()
    {
        $this->forge->dropTable('anime_jadwal_rilis');
    }
}
