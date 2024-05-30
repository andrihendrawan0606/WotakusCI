<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EpisodeAnime extends Migration
{
    public function up()
    {
                // Membuat kolom/field untuk tabel news
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'anime_id'       => [
				'type'           => 'INT',
				'constraint'     => 11,
                'unsigned'       => true
			],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
			],
			'episode_number'       => [
				'type'           => 'INT',
				'constraint'     => 11,
                'unsigned'       => true
			],
			'deskripsi'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'GambarPreview'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'video_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
		]);

		// Membuat primary key dan foreign key
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('anime_id', 'JujutsuKaisen', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('anime_id', 'JujutsuKaisen', 'id', 'CASCADE', 'CASCADE');
		// Membuat tabel anime
		$this->forge->createTable('EpisodeAnime', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('EpisodeAnime');
    }
}
