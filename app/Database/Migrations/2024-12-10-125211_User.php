<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class User extends Migration
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
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true
            ],
            'password' => [
                'type'       => 'NVARCHAR',
                'constraint' => '500'
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'sobrenome' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true
            ],
            'role' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('role', 'roles', 'id');
        $this->forge->createTable('users');

        // Chamar a seeder
        $seeder = \Config\Database::seeder();
        $seeder->call('UsersSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
