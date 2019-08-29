<?php namespace App\Interfaces;

use App\Http\Requests\Address\StoreAddressRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AddressRepositoryContract
{
    public function all(): Collection;

    public function find(String $id): Model;

    public function store(StoreAddressRequest $request): Model;

    public function update(StoreAddressRequest $request, String $id): Model;

    public function delete(String $id): void;

    public function setAsPrimary(String $id): void;

    public function removePrimary(String $id): void;

    public function setGuard(String $guard): void;
}