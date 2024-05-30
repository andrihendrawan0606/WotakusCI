<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EpisodeViews extends Migration
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
            'episode_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'view_count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('episode_id', 'EpisodeAnime', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('episode_views');
    }

    public function down()
    {
        $this->forge->dropTable('episode_views');
    }
}
