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
            'mal_id' => [
                'type' => 'INT',
                'constraint' => 11,
				'unsigned'   => true,
                'null' => true
			],
			'mal_score' => [
				'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'default'    => 0.00,
			],
			'source' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
			'season' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'release_year' => [
                'type'       => 'INT',
                'constraint' => 4,
                'null'       => true,
            ],
			'avg_rating' => [
				'type'       => 'DECIMAL',
				'constraint' => '3,2',
				'default'    => 0.00,
				'null'       => true
			],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('animes', TRUE);
    }
    

    public function down()
    {
        $this->forge->dropTable('animes', 'mal_score');
    }
}
