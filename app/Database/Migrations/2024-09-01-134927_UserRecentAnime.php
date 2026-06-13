<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserRecentAnime extends Migration
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
                'unsigned' => true, // Sesuaikan dengan kolom `id` di tabel `users`
            ],
            'anime_id' => [
                'type' => 'INT',
                'unsigned' => true, // Sesuaikan dengan kolom `id` di tabel `animes`
            ],
            'episode_id' => [ 
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,  // Null jika recent hanya menyimpan anime tanpa episode
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
        $this->forge->addForeignKey('anime_id', 'animes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('episode_id', 'episodeanime', 'id', 'CASCADE', 'CASCADE');  // Relasi ke tabel episode
        $this->forge->createTable('user_recent_anime');
    }

    public function down()
    {
        $this->forge->dropTable('user_recent_anime');
    }
}
