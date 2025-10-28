<?php

namespace App\Controllers\Admin;

use App\Core\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index(Request $request): Response
    {
        $html = $this->view->render('admin/index');
        return new Response($html);
    }
}
