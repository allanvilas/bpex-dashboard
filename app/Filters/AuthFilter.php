<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            // Evitar redirecionar a página de login para si mesma
            if (current_url() !== site_url('/pages/login')) {
                return redirect()->to('/pages/login')->with('error', 'Você precisa estar logado para acessar esta página.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer aqui
    }
}