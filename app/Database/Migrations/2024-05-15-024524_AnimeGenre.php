<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnimeGenre extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'anime_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'genre_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'

        ]);

        $this->forge->addPrimaryKey(['anime_id', 'genre_id']);

        $this->forge->addForeignKey('anime_id', 'animes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('genre_id', 'Genre', 'id', 'CASCADE', 'CASCADE');

		$this->forge->createTable('AnimeGenre', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('AnimeGenre');
    }
}
