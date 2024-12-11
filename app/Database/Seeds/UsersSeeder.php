<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin', 
                'email' => 'admin@gmail.com', 
                'nome' => 'admin', 
                'sobrenome' => 'admin',
                'password' => password_hash(env('ADMIN_FIRST_ACCESS_PASSWORD'), PASSWORD_DEFAULT), 
                'role' => 1,
            ],
            [
                'username' => 'basicUser', 
                'email' => 'teste.user@gmail.com', 
                'nome' => 'user', 
                'sobrenome' => 'basic',
                'password' => password_hash(env('ADMIN_FIRST_ACCESS_PASSWORD'), PASSWORD_DEFAULT), 
                'role' => 2,
            ],
        ];

        // Inserir os dados na tabela roles
        $this->db->table('users')->insertBatch($data);
    }
}
