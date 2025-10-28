<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Csrf;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController {
    private View $view;
    private ProductRepository $repo;
    private ProductService $service;

    public function __construct() {
        $this->view = new View();
        $this->repo = new ProductRepository();
        $this->service = new ProductService();
    }

    public function index(Request $request): Response {
        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 5;
        $total = $this->repo->countAll();
        $products = $this->repo->paginate($page, $perPage);
        $pages = (int)ceil($total / $perPage);
        $html = $this->view->render('admin/products/index', compact('products','page','pages'));
        return new Response($html);
    }

    public function create(): Response {
        $html = $this->view->render('admin/products/create', ['csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function store(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $file = $request->files->get('image');
        $errors = $this->service->validate($request->request->all(), $file);
        if ($errors) {
            $html = $this->view->render('admin/products/create', ['csrf' => Csrf::token(), 'errors' => $errors, 'old' => $request->request->all()]);
            return new Response($html, 422);
        }
        $imagePath = $this->service->storeImage($file);
        $product = $this->service->make($request->request->all(), $imagePath);
        $id = $this->repo->create($product);
        return new RedirectResponse('/admin/products/show?id=' . $id);
    }

    public function show(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $product = $this->repo->find($id);
        if (!$product) return new Response('Produto não encontrado', 404);
        $html = $this->view->render('admin/products/show', ['product' => $product]);
        return new Response($html);
    }

    public function edit(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $product = $this->repo->find($id);
        if (!$product) return new Response('Produto não encontrado', 404);
        $html = $this->view->render('admin/products/edit', ['product' => $product, 'csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function update(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $data = $request->request->all();
        $file = $request->files->get('image');
        $errors = $this->service->validate($data, $file);
        if ($errors) {
            $html = $this->view->render('admin/products/edit', ['product' => array_merge($this->repo->find((int)$data['id']), $data), 'csrf' => Csrf::token(), 'errors' => $errors]);
            return new Response($html, 422);
        }
        $imagePath = $this->service->storeImage($file) ?? ($this->repo->find((int)$data['id'])['image_path'] ?? null);
        $product = $this->service->make($data, $imagePath);
        if (!$product->id) return new Response('ID inválido', 422);
        $this->repo->update($product);
        return new RedirectResponse('/admin/products/show?id=' . $product->id);
    }

    public function delete(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $id = (int)$request->request->get('id', 0);
        if ($id > 0) $this->repo->delete($id);
        return new RedirectResponse('/admin/products');
    }
}
