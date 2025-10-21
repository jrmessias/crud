<?php
namespace App\Models;

class Product {
    public ?int $id;
    public string $name;
    public float $price;
    public ?string $image_path;
    public string $created_at;

    public function __construct(?int $id, string $name, float $price, ?string $image_path = null, string $created_at = '') {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->image_path = $image_path;
        $this->created_at = $created_at;
    }
}
