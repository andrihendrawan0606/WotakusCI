<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JujutsuKaisen extends Migration
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
			'Judul'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
            'Poster'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
			'BackgroundCover'    => [
				'type'           => 'VARCHAR',
				'constraint'     => '500'
			],
			'Desc'      => [
				'type'           => 'TEXT',
				'constraint'     => 255,
			],
			'Eps' => [
				'type'           => 'INT',
				'constraint'     => '5'
			],
            'Durasi' => [
				'type'           => 'INT',
				'constraint'     => '5'
			],
            'Rilis'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
            'JudulLainnya'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
            'SeriLainnya'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
            // 'genre_id'       => [
			// 	'type'           => 'INT',
			// 	'constraint'     => '5'
			// ],
			'status'      => [
				'type'           => 'ENUM',
				'constraint'     => ['Completed', 'On-Going'],
				'default'        => 'Completed',
			],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel anime
		$this->forge->createTable('jujutsuKaisen', TRUE);
    }
    

    public function down()
    {
        $this->forge->dropTable('jujutsuKaisen');
    }
}
