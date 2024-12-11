<?php 
namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function loginPage()
    {
        // Exibir a view do formulário de login
        if (session()->get('logged_in')) {
            // Evitar redirecionar a página de login para si mesma
            return redirect()->to('/pages/dashboard');            
        } else {
            return view('/pages/login');
        }
    }

    public function authenticate()
    {
        $session = session();
        $userModel = new UserModel();

        // Capturar dados do formulário
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Procurar usuário pelo email
        $user = $userModel->where('email', $email)->where('deleted_at',null)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Salvar dados na sessão
            $session->set([
                'user_id' => $user['id'],
                'user_name' => $user['nome'],
                'user_email' => $user['email'],
                'logged_in' => true,
            ]);

            return redirect()->to('/pages/dashboard');
        }

        return redirect()->back()->with('error', 'Credenciais inválidas!');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/pages/login');
    }
}
