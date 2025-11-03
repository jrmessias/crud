<?php

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Flash;
use App\Core\View;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    private View $view;
    private UserRepository $repo;

    private AuthService $auth;

    public function __construct(){
        $this->view = new View();
        $this->auth = new AuthService();
    }

    function showLogin(): Response
    {
        $html = $this->view->render('auth/login', ['csrf' => Csrf::token()]);
        return new Response($html);
    }

    public function login(Request $req): Response
    {
        if (!Csrf::validate($req->request->get('_csrf'))) return new Response('CSRF inválido', 419);
        $email = (string)$req->request->get('email', '');
        $password = (string)$req->request->get('password', '');

        if (!$this->auth->attempt($email, $password)) {
            Flash::push('danger', 'Credenciais inválidas');
            return new RedirectResponse('/auth/login');
        }

        Flash::push('success', 'Bem-vindo!');
        return new RedirectResponse('/admin');
    }

    public function logout(): Response
    {
        $this->auth->logout();
        Flash::push('info', 'Sessão encerrada.');
        return new RedirectResponse('/auth/login');
    }

    public function create(): Response
    {
        $id = $this->auth->register('Teste', 'teste@teste.com', 'teste123');
        Flash::push('info', 'Admin criado #' . $id);
        return new RedirectResponse('/auth/login');
    }
}
