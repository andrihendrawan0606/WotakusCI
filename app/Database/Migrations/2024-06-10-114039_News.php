<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class News extends Migration
{
    public function up()
    {
        // Tabel news
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'Judul' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'subJudul' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 100
            ],
            'profileImg' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'waktu_penayangan' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
            'preview_gambar' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'isiKonten' => [
                'type' => 'TEXT'
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('news');

        // Tabel tag
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'namaTag' => [
                'type' => 'VARCHAR',
                'constraint' => 100
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
        $this->forge->createTable('tags');

        // Tabel news dan tag
        $this->forge->addField([
            'news_id' => [
                'type' => 'INT'
            ],
            'tag_id' => [
                'type' => 'INT'
            ]
        ]);

        $this->forge->addKey(['news_id', 'tag_id'], true);
        $this->forge->addForeignKey('news_id', 'news', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tags', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('news_tags');

        // Tabel news media
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'news_id' => [
                'type' => 'INT'
            ],
            'media_type' => [
                'type' => 'ENUM',
                'constraint' => ['image', 'embed']
            ],
            'media_url' => [
                'type' => 'TEXT'
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
        $this->forge->addForeignKey('news_id', 'news', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('news_media');
    }

    public function down()
    {
        $this->forge->dropTable('news_media');
        $this->forge->dropTable('news_tags');
        $this->forge->dropTable('tags');
        $this->forge->dropTable('news');
    }
}
