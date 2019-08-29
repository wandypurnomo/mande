<?php namespace App\Repositories;

use App\Constants\PaymentStatus;
use App\Constants\TransactionStatus;
use App\Http\Requests\Transaction\AddCartRequest;
use App\Http\Requests\Transaction\CheckoutRequest;
use App\Http\Requests\Transaction\UpdateCartRequest;
use App\Interfaces\TransactionRepositoryContract;
use App\Models\Address;
use App\Models\Transaction;
use Carbon\Carbon;
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
    public $address;

    public function __construct(Transaction $model, Address $address)
    {
        $this->model = $model;
        $this->address = $address;
        $this->userId = auth()->user()->id;
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $data = $this->model->newQuery();

        $where = function (Builder $builder) use ($request) {
            if ($request->has("code") && $request->get("code") != "") {
                $builder->where("code", $request->get("code"));
            }

            if ($request->has("user") && $request->get("user") != "") {
                $builder->where("user_id", $request->get("user"));
            }

            if ($request->has("status") && $request->get("status") != "") {
                $builder->where("status", $request->get("status"));
            }

            if ($request->has("start-date") && $request->get("start-date") != "") {
                $builder->whereDate("created_at", ">=", $request->get("start-date"));
            }

            if ($request->has("end-date") && $request->get("end-date") != "") {
                $builder->whereDate("created_at", "<=", $request->get("end-date"));
            }
        };

        $data->where($where);
        $data = $data->latest()->paginate(10);
        return $data;
    }

    public function allByUser(Request $request): LengthAwarePaginator
    {
        $data = $this->model->newQuery();

        $where = function (Builder $builder) use ($request) {
            $builder->where("user_id", $this->userId);

            if ($request->has("code") && $request->get("code") != "") {
                $builder->where("code", $request->get("code"));
            }

            if ($request->has("status") && $request->get("status") != "") {
                $builder->where("status", $request->get("status"));
            }

            if ($request->has("start-date") && $request->get("start-date") != "") {
                $builder->whereDate("created_at", ">=", $request->get("start-date"));
            }

            if ($request->has("end-date") && $request->get("end-date") != "") {
                $builder->whereDate("created_at", "<=", $request->get("end-date"));
            }
        };

        $data->where($where);
        $data = $data->latest()->paginate(10);
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

    public function currentCartBasket(): Model
    {
        $data = $this->model->newQuery()->where("status", TransactionStatus::CART)->where("user_id", $this->userId)->latest()->first();

        if (is_null($data)) {
            $data = $this->createCartBasket();
        }

        return $data;
    }

    private function createCartBasket(): Model
    {
        $data = $this->model->newQuery()->create([
            "user_id" => $this->userId,
            "code" => $this->generateCode(),
            "status" => TransactionStatus::CART,
            "payment_status" => PaymentStatus::UNPAID
        ]);

        return $data;
    }

    private function generateCode()
    {
        return Carbon::now()->format("YmdHis") . rand(100, 999);
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

    public function checkout(CheckoutRequest $request): void
    {
        $transaction = $this->find($request->input("transaction_id"));
        $address = $this->address->newQuery()->findOrFail($request->input("address_id"));

        try {
            DB::beginTransaction();
            // update transaction to placed
            $this->setAsPlaced($request->input("transaction_id"));

            // insert address
            $transaction->address()->create([
                "name" => $address->name,
                "address" => $address->address,
                "hint" => $address->hint,
                "recipient" => $address->recipient,
                "phone" => $address->phone,
            ]);

            DB::commit();

            // TODO: Notify admin about this checkout, so that admin can followup
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function find(String $id): Model
    {
        $data = $this->model->newQuery()->where("id", $id)->with("details", "address", "couriers", "user")->firstOrFail();
        return $data;
    }

    public function setAsPlaced(String $id): void
    {
        $data = $this->find($id);
        $data->update(["status" => TransactionStatus::PLACED]);
    }

    public function setAsPaid(String $id): void
    {
        $data = $this->find($id);
        $data->update(["status" => PaymentStatus::PAID]);
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