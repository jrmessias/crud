<?php

namespace App\Controllers;

use App\Core\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index(Request $request): Response
    {
        $congrats = $request->query->get('congrats', false);
        $html = $this->view->render('site/index', compact('congrats'));
        return new Response($html);
    }
}
