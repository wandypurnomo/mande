<?php namespace App\Interfaces;

use App\Http\Requests\Transaction\AddCartRequest;
use App\Http\Requests\Transaction\CheckoutRequest;
use App\Http\Requests\Transaction\UpdateCartRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface TransactionRepositoryContract
{
    public function all(Request $request): LengthAwarePaginator;

    public function allByUser(Request $request): LengthAwarePaginator;

    public function currentCartBasket(): Model;

    public function find(String $id): Model;

    public function findByUser(String $id): Model;

    public function addCart(AddCartRequest $request): Model;

    public function updateCart(UpdateCartRequest $request): Model;

    public function removeCart(String $id): void;

    public function checkout(CheckoutRequest $request): void;

    public function setAsPaid(String $id): void;

    public function setAsPlaced(String $id): void;

    public function setAsOnDelivery(String $id): void;

    public function setAsDone(String $id, String $notes): void;

    public function setAsFailed(String $id, String $notes): void;

    public function setGuard(String $guard): void;

    public function assignCourier(String $id): void;
}