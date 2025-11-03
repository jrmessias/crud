<?php
namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\View;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\ProductService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController {
    private View $view;
    private UserRepository $repo;
    private UserService $service;

    public function __construct() {
        $this->view = new View();
        $this->repo = new UserRepository();
        $this->service = new UserService();
    }

    public function index(Request $request): Response {
        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 5;
        $total = $this->repo->countAll();
        $users = $this->repo->paginate($page, $perPage);
        $pages = (int)ceil($total / $perPage);
        $html = $this->view->render('admin/users/index', compact('users','page','pages'));
        return new Response($html);
    }

    public function create(): Response {
        $html = $this->view->render('admin/users/create', ['csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function store(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf')))
            return new Response('Token CSRF inválido', 419);
        $errors = $this->service->validate($request->request->all());

        $emailExists = $this->repo->findByEmail($request->get('email'));
        if($emailExists){
            $errors['email'] = "E-mail já utilizado.";
        }

        if ($errors) {
            $html = $this->view->render('admin/users/create', ['csrf' => Csrf::token(), 'errors' => $errors, 'old' => $request->request->all()]);
            return new Response($html, 422);
        }

        $user = $this->service->make($request->request->all());
        $user->password_hash = AuthService::hashPassword($user->password_hash);
        $id = $this->repo->create($user);

        return new RedirectResponse('/admin/users/show?id=' . $id);
    }

    public function show(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $user = $this->repo->find($id);
        if (!$user) return new Response('Usuário não encontrado', 404);
        $html = $this->view->render('admin/users/show', ['user' => $user]);
        return new Response($html);
    }

    public function edit(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $product = $this->repo->find($id);
        if (!$product) return new Response('Usuário não encontrado', 404);
        $html = $this->view->render('admin/users/edit', ['product' => $product, 'csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function update(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $data = $request->request->all();
        $errors = $this->service->validate($data);

        $emailExists = $this->repo->findByEmailNotId($request->get('email'), $data['id']);
        if($emailExists){
            $errors['email'] = "E-mail já utilizado.";
        }

        if ($errors) {
            $html = $this->view->render('admin/users/edit', ['product' => array_merge($this->repo->find((int)$data['id']), $data), 'csrf' => Csrf::token(), 'errors' => $errors]);
            return new Response($html, 422);
        }

        $product = $this->service->make($data);
        if (!$product->id) return new Response('ID inválido', 422);
        $this->repo->update($product);
        return new RedirectResponse('/admin/users/show?id=' . $product->id);
    }

    public function delete(Request $request): Response {
        $total = $this->repo->countAll();
        if($total === 1){
            return new Response('Token CSRF inválido', 419);
        }
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $id = (int)$request->request->get('id', 0);
        if ($id > 0) $this->repo->delete($id);
        return new RedirectResponse('/admin/users');
    }
}
