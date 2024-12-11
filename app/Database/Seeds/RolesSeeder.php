<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'role' => 'ADMIN',
                'description' => 'Administrator role with full access'
            ],
            [
                'role' => 'USER',
                'description' => 'Default user role with limited access'
            ],
        ];

        // Inserir os dados na tabela roles
        $this->db->table('roles')->insertBatch($data);
    }
}
