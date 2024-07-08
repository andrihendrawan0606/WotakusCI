<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AnimeType extends Migration
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
            'tipeAnime' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('animeTipe');
    }

    public function down()
    {
        $this->forge->dropTable('animeTipe');
    }
}
