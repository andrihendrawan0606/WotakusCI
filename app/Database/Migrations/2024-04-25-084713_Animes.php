<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Animes extends Migration
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
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
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
            'typeId'       => [
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
			'statusTayang'      => [
				'type'           => 'ENUM',
				'constraint'     => ['draft', 'published'],
				'default'        => 'draft',
			],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);
		// $this->forge->addForeignKey('typeId', 'animeTipe', 'id', 'CASCADE', 'CASCADE');
		// Membuat tabel anime
		$this->forge->createTable('animes', TRUE);
    }
    

    public function down()
    {
        $this->forge->dropTable('animes');
    }
}
