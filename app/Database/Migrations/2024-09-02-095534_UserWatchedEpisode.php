<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserWatchedEpisode extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'episode_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'watched_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        // Primary Key
        $this->forge->addKey('id', true);

        // Foreign Key
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('episode_id', 'EpisodeAnime', 'id', 'CASCADE', 'CASCADE');

        // Create Table
        $this->forge->createTable('user_watched_episodes');
    }

    public function down()
    {
        // Drop table
        $this->forge->dropTable('user_watched_episodes');
    }
}
