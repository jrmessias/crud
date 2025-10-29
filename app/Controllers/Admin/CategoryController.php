<?php
namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\View;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController {
    private View $view;
    private CategoryRepository $repo;
    private CategoryService $service;

    public function __construct() {
        $this->view = new View();
        $this->repo = new CategoryRepository();
        $this->service = new CategoryService();
    }

    public function index(Request $request): Response {
        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 5;
        $total = $this->repo->countAll();
        $categories = $this->repo->paginate($page, $perPage);
        $pages = (int)ceil($total / $perPage);
        $html = $this->view->render('admin/categories/index', compact('categories','page','pages'));
        return new Response($html);
    }

    public function create(): Response {
        $html = $this->view->render('admin/categories/create', ['csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function store(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $errors = $this->service->validate($request->request->all());
        if ($errors) {
            $html = $this->view->render('admin/categories/create', ['csrf' => Csrf::token(), 'errors' => $errors, 'old' => $request->request->all()]);
            return new Response($html, 422);
        }
        $category = $this->service->make($request->request->all());
        $id = $this->repo->create($category);
        return new RedirectResponse('/admin/categories/show?id=' . $id);
    }

    public function show(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $category = $this->repo->find($id);
        if (!$category) return new Response('Category não encontrada', 404);
        $html = $this->view->render('admin/categories/show', ['cagetory' => $category]);
        return new Response($html);
    }

    public function edit(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $category = $this->repo->find($id);
        if (!$category) return new Response('Categoria não encontrada', 404);
        $html = $this->view->render('admin/categories/edit', ['category' => $category, 'csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function update(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $data = $request->request->all();
        $file = $request->files->get('image');
        $errors = $this->service->validate($data);
        if ($errors) {
            $html = $this->view->render('admin/categories/edit', ['category' => array_merge($this->repo->find((int)$data['id']), $data), 'csrf' => Csrf::token(), 'errors' => $errors]);
            return new Response($html, 422);
        }
        $category = $this->service->make($data);
        if (!$category->id) return new Response('ID inválido', 422);
        $this->repo->update($category);
        return new RedirectResponse('/admin/categories/show?id=' . $category->id);
    }

    public function delete(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $id = (int)$request->request->get('id', 0);
        if ($id > 0) $this->repo->delete($id);
        return new RedirectResponse('/admin/categories');
    }
}
