<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SeriLainnya extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'anime_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'seriLainnya_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
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
        $this->forge->addForeignKey('anime_id', 'animes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('seriLainnya_id', 'animes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('seriLainnya');
    }

    public function down()
    {
        $this->forge->dropTable('seriLainnya');
    }
}
