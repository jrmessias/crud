<?php

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\View;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    private View $view;
    private UserRepository $repo;
    private UserService $service;

    public function __construct()
    {
        $this->view = new View();
        $this->repo = new UserRepository();
        $this->service = new UserService();
    }

    public function login(Request $request): Response
    {
        $html = $this->view->render('auth/login');
        return new Response($html);
    }

    public function authenticate(Request $request): Response
    {
        $errors = $this->service->validate($request->request->all());
        if ($errors) {
            $html = $this->view->render('auth/login', ['csrf' => Csrf::token(), 'errors' => $errors, 'old' => $request->request->all()]);
            return new Response($html, 422);
        }

        $email = $request->get('email');
        $password = $request->get('password');
        $user = $this->repo->authenticate($email, $password);

        if ($user) {
            header('Location: /admin');
            exit();
        }

        $html = $this->view->render('auth/login');
        return new Response($html);
    }
}
