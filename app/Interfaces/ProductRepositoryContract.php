<?php namespace App\Interfaces;

use App\Http\Requests\Product\AddStockRequest;
use App\Http\Requests\Product\StoreProductRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ProductRepositoryContract
{
    public function all(Request $request): LengthAwarePaginator;

    public function find(String $id): Model;

    public function store(StoreProductRequest $request): Model;

    public function update(String $productId, StoreProductRequest $request): Model;

    public function delete(String $id): void;

    public function allStockByProduct(String $productId): LengthAwarePaginator;

    public function countStockByProduct(String $productId): int;

    public function addStock(String $productId, AddStockRequest $request): Model;

    public function acceptStockAdjustment(String $stockId): void;

    public function rejectStockAdjustment(String $stockId): void;
}