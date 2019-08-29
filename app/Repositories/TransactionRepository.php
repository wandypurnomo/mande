<?php namespace App\Repositories;

use App\Constants\PaymentStatus;
use App\Constants\TransactionStatus;
use App\Http\Requests\Transaction\AddCartRequest;
use App\Http\Requests\Transaction\CheckoutRequest;
use App\Http\Requests\Transaction\UpdateCartRequest;
use App\Interfaces\TransactionRepositoryContract;
use App\Models\Transaction;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TransactionRepository implements TransactionRepositoryContract
{
    public $model;
    public $userId;
    public $guard;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
        $this->userId = auth()->user()->id;
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $data = $this->model->newQuery();

        // TODO: set filter condition

        $data = $data->paginate(10);
        return $data;
    }

    public function allByUser(Request $request): LengthAwarePaginator
    {
        $data = $this->model->newQuery();

        // TODO: set filter condition
        $where = function (Builder $builder) use ($request) {
            $builder->where("user_id", $this->userId);
        };

        $data->where($where);
        $data = $data->paginate(10);
        return $data;
    }

    public function currentCartBasket(): Model
    {
        $data = $this->model->newQuery()->where("status", TransactionStatus::CART)->where("user_id", $this->userId)->latest()->firstOrFail();
        return $data;
    }

    public function find(String $id): Model
    {
        $data = $this->model->newQuery()->where("id", $id)->with("details", "address", "couriers", "user")->firstOrFail();
        return $data;
    }

    public function findByUser(String $id): Model
    {
        $data = $this->model->newQuery()->where("id", $id)->where("user_id", $this->userId)->with("details", "address", "couriers", "user")->firstOrFail();
        return $data;
    }

    public function addCart(AddCartRequest $request): Model
    {
        $cartBasket = $this->currentCartBasket();
        $item = $cartBasket->details()->create();
        return $item;
    }

    public function updateCart(UpdateCartRequest $request): Model
    {
        $cartBasket = $this->currentCartBasket();
        $item = $cartBasket->details()->update();
        return $item;
    }

    public function removeCart(String $id): void
    {
        try {
            DB::beginTransaction();
            $this->currentCartBasket()->details()->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        $this->currentCartBasket()->delete();
    }

    public function checkout(CheckoutRequest $request): Model
    {
        // TODO: Implement checkout() method.
    }

    public function setAsPaid(String $id): void
    {
        $data = $this->find($id);
        $data->update(["status" => PaymentStatus::PAID]);
    }

    public function setAsPlaced(String $id): void
    {
        $data = $this->find($id);
        $data->update(["status" => TransactionStatus::PLACED]);
    }

    public function setAsOnDelivery(String $id): void
    {
        $data = $this->find($id);
        $data->update(["status" => TransactionStatus::ON_DELIVERY]);
    }

    public function setAsDone(String $id, String $notes): void
    {
        $data = $this->find($id);
        $data->update(["status" => TransactionStatus::DONE, "notes" => $notes]);
    }

    public function setAsFailed(String $id, String $notes): void
    {
        $data = $this->find($id);
        $data->update(["status" => TransactionStatus::FAILED, "failed_reason" => $notes]);
    }

    public function setGuard(String $guard): void
    {
        $this->guard = $guard;
        $this->userId = auth($this->guard)->user()->id;
    }

    public function assignCourier(String $id): void
    {
        $data = $this->find($id);
        $data->couriers()->sync([$id]);
    }
}