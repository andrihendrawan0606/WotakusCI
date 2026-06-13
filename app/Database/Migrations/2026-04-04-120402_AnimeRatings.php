<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnimeRatings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'anime_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'rating' => [
                'type'       => 'TINYINT', 
                'constraint' => 2,
            ],
            'review' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id', true);
        // Foreign Key agar data konsisten
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('anime_id', 'animes', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('anime_ratings');
    }

    public function down()
    {
        $this->forge->dropTable('anime_ratings');
    }
}
