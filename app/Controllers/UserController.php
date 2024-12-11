<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;

class UserController extends BaseController
{

    public function userPage()
    {
        // $userModel = new UserModel();
        // $data = [
        //     'users' => $userModel->findAll(),
        // ];
        $userData = json_encode($this->listarUsuariosAtivos());
        $rolesData = json_encode($this->listarRoles());
        
        return view('pages/user',[
             'users' => $userData,
             'roles' => $rolesData,
        ]);
    }
    public function listarUsuariosAtivos() {
        $userModel = new UserModel();

        $data = [
            'users' => $userModel->where('deleted_at', null)->find(),
        ];

        return $data;
    }

    public function listarRoles() {
        $roleModel = new RoleModel();

        $data = [
            'roles' => $roleModel->findAll(),
        ];

        return $data;
    }

    public function criarNovoUsuario() {
        $userModel = new UserModel();
        $roleModel = new RoleModel();

        $roleName = $this->request->getPost('role') ?? '';
        $role = $roleModel->where('role', $roleName)->first();

        if ($role) {
            $roleId = $role['id'];
            // Role encontrado, use o $roleId conforme necessário
        } else {
            return redirect()->back()->with('error', 'O role especificado não existe.');
        }
        
        $this->response->setBody('Usuário criado com sucesso!')->sendBody();

        $data = [
            'username' => '-', // excluir do model
            'email' => $this->request->getPost('email'), 
            'nome' => $this->request->getPost('nome'), 
            'sobrenome' => $this->request->getPost('sobrenome'), 
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), 
            'role' => $roleId ?? 2,
        ];

        // Validação básica
        if (empty($data['password'])) {
            return redirect()->back()->with('error', 'O campo de senha é obrigatório.');
        }

        // Tentar salvar
        if ($userModel->save($data)) {
            return redirect()->to('/pages/usuarios')->with('success', 'Usuário criado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao criar o usuário. Verifique os dados e tente novamente.');
        }
    }

    // precisa ajustar o modelo de dados para poder usar corretamente o soft delete
    // public function deletarUsuario($id) {
    //     $userModel = new UserModel();

    //     $data = array('deleted_at' => date('Y-m-d H:i:s'));
        
    //     $userModel->update($id, $data );

    //     // Redireciona de volta para a página de usuários
    //     return redirect()->to('/pages/usuarios');
    // }
    

    // hard delete
    public function deletarUsuario($id) {
        $userModel = new UserModel();
        
        $userModel->delete($id);

        // Redireciona de volta para a página de usuários
        return redirect()->to('/pages/usuarios');
    }

    public function atualizarUsuario() {
        $userModel = new UserModel();
        $roleModel = new RoleModel();

        $data = [
            'username' => $this->request->getPost('username'), 
            'email' => $this->request->getPost('email'), 
            'nome' => $this->request->getPost('nome'), 
            'sobrenome' => $this->request->getPost('sobrenome'), 
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), 
            'role' => $roleModel->where('role', $this->request->getPost('role'))->first()->id,
        ];

        $userModel->update($this->request->getPost('id'), $data);
    }

    public function atualizarSenha() {
        $userModel = new UserModel();

        var_dump($_POST);
        die();

        $data = [
            'password' => password_hash($this->request->getPost('newPassword'), PASSWORD_DEFAULT),
        ];

        $userModel->update($this->request->getPost('id'), $data);
    }
}