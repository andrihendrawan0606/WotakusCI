<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Genre extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
            'genre' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug_genre' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
			'genre_id'       => [
				'type'           => 'INT',
				'constraint'     => 5,
                'unsigned'       => true
			],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
		]);

		// Membuat primary key dan foreign key
		$this->forge->addKey('id', TRUE);
        // $this->forge->addForeignKey('id', 'JujutsuKaisen', 'id', 'CASCADE', 'CASCADE');
		// Membuat tabel anime
		$this->forge->createTable('Genre', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('Genre');
    }
}
