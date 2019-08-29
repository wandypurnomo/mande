<?php namespace App\Repositories;

use App\Constants\ActiveStatus;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Interfaces\AddressRepositoryContract;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AddressRepository implements AddressRepositoryContract
{
    public $model;
    public $userId;
    public $guard;

    public function __construct(Address $model, $guard = null)
    {
        $this->model = $model;
        $this->guard = $guard;
        $this->userId = auth($this->guard)->user()->id;
    }

    public function store(StoreAddressRequest $request): Model
    {
        $request->merge(["user_id" => $this->userId]);
        $request->merge(["is_primary" => $this->all()->count() == 0 ? ActiveStatus::ACTIVE : ActiveStatus::INACTIVE]);
        $only = $request->only(["name", "address", "hint", "recipient", "phone", "user_id", "is_primary", "lat", "lng"]);

        $data = $this->model->newQuery()->create($only);
        return $data;
    }

    public function all(): Collection
    {
        $data = $this->model->newQuery()->where("user_id", $this->userId)->get();
        return $data;
    }

    public function update(StoreAddressRequest $request, String $id): Model
    {
        $address = $this->find($id);
        $request->merge(["user_id" => $this->userId]);
        $request->merge(["is_primary" => $this->all()->count() == 0 ? ActiveStatus::ACTIVE : ActiveStatus::INACTIVE]);
        $only = $request->only(["name", "address", "hint", "recipient", "phone", "user_id", "is_primary", "lat", "lng"]);

        $address->update($only);
        return $address;
    }

    public function find(String $id): Model
    {
        $data = $this->model->newQuery()->where("user_id", $this->userId)->where("id", $id)->firstOrFail();
        return $data;
    }

    public function delete(String $id): void
    {
        $data = $this->find($id);
        try {
            $data->delete();
        } catch (\Exception $e) {
        }
    }

    public function setAsPrimary(String $id): void
    {
        $this->setAllAsNotPrimary();
        $data = $this->find($id);
        $data->update(["is_primary" => ActiveStatus::ACTIVE]);
    }

    public function removePrimary(String $id): void
    {
        $data = $this->find($id);
        $data->update(["is_primary" => ActiveStatus::INACTIVE]);
    }

    public function setGuard(String $guard): void
    {
        $this->guard = $guard;
        $this->userId = auth($this->guard)->user()->id;
    }

    private function setAllAsNotPrimary(): void
    {
        $this->model->newQuery()->where("user_id", $this->userId)->update(["is_primary" => ActiveStatus::INACTIVE]);
    }
}