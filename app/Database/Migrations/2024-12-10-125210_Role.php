<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('roles');

        // Chamar a seeder
        $seeder = \Config\Database::seeder();
        $seeder->call('RolesSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}
