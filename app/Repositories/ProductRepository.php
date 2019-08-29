<?php namespace App\Repositories;

use App\Constants\ActiveStatus;
use App\Constants\StockType;
use App\Http\Requests\Product\AddStockRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Interfaces\ProductRepositoryContract;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;

class ProductRepository implements ProductRepositoryContract
{
    public $product;
    public $stock;

    public function __construct(Product $product, Stock $stock)
    {
        $this->product = $product;
        $this->stock = $stock;
    }

    public function all(Request $request): LengthAwarePaginator
    {
        $product = $this->product->newQuery();

        $where = function (Builder $builder) use ($request) {
            if ($request->has("q") && $request->get("q") != "") {
                $q = $request->get("q");
                $builder->where("title", "like", "%$q%")
                    ->orWhere("description", "like", "%$q%");
            }

            if ($request->has("category") && $request->get("category") != "") {
                $builder->where("category_id", $request->get("category"));
            }
        };

        $product->where($where);
        return $product->paginate(10);
    }

    public function allAvailable(Request $request): LengthAwarePaginator
    { // TODO: join with transaction
        $product = $this->product->newQuery();
        $product->selectRaw("products.*,(COUNT(stocks.id) where stocks.accepted_at IS NOT NULL) as stock_count");
        $product->join("stocks", "stocks.id", "=", "products.id");

        $where = function (Builder $builder) use ($request) {
            $builder->where("products.status", ActiveStatus::ACTIVE);
            $builder->where("stock_count", ">", 0);

            if ($request->has("q") && $request->get("q") != "") {
                $q = $request->get("q");
                $builder->where("title", "like", "%$q%")
                    ->orWhere("description", "like", "%$q%");
            }

            if ($request->has("category") && $request->get("category") != "") {
                $builder->where("category_id", $request->get("category"));
            }
        };

        $product->where($where);
        return $product->paginate(10);
    }

    public function find(String $id): Model
    {
        return $this->product->newQuery()->findOrFail($id);
    }

    public function store(StoreProductRequest $request): Model
    {
        if ($request->hasFile("image_file")) {
            $name = Str::slug($request->input("name")) . "-" . rand(1000, 9999);
            $ext = $request->file("image_file")->getClientOriginalExtension();

            $name = $name . "." . $ext;
            $path = "products/";

            $filename = $path . $name;
            $request->file("image_file")->storeAs($path, $name, "public");
            $request->merge(["image" => $filename]);
        }
        $request->merge(["user_id" => $request->user()->id]);
        $only = $request->only(["category_id", "name", "description", "image", "price", "label_id", "user_id", "selling_price", "base_price"]);
        $store = $this->product->newQuery()->create($only);
        return $store;
    }

    public function update(String $productId, StoreProductRequest $request): Model
    {
        $product = $this->product->newQuery()->findOrFail($productId);

        if ($request->hasFile("image_file")) {

            if (isset($product->image) && Storage::disk("public")->exists($product->image)) {
                Storage::disk("public")->delete($product->image);
            }

            $name = Str::slug($request->input("name")) . "-" . rand(1000, 9999);
            $ext = $request->file("image_file")->getClientOriginalExtension();

            $name = $name . "." . $ext;
            $path = "products/";

            $filename = $path . $name;
            $request->file("image_file")->storeAs($path, $name, "public");
            $request->merge(["image" => $filename]);
        }

        $request->merge(["user_id" => $request->user()->id]);
        $only = $request->only(["category_id", "name", "description", "image", "price", "label_id", "user_id"]);
        $product->update($only);
        return $product;
    }

    public function delete(String $id): void
    {
        try {
            $this->product->newQuery()->findOrFail($id)->delete();
        } catch (\Exception $e) {
        }
    }

    public function allStockByProduct(String $productId): LengthAwarePaginator
    {
        $stocks = $this->stock->newQuery();

        $stocks->where("product_id", $productId);

        return $stocks->paginate(10);
    }

    public function countStockByProduct(String $productId): int
    {
        $stocks = $this->stock->newQuery();

        $stocks->whereNotNull("accepted_at");
        $stocks->where("product_id", $productId);

        return $stocks->sum("amount");
    }

    public function addStock(String $productId, AddStockRequest $request): Model
    {
        $type = $request->input("type");

        $request->merge(["product_id" => $productId]);
        $request->merge(["user_id" => auth()->user()->id]);
        $request->merge(["accepted_at" => $type == StockType::STOCK ? Carbon::now() : null]);

        $only = $request->only(["amount", "type", "description", "user_id", "product_id", "accepted_at"]);
        $store = $this->stock->newQuery()->create($only);
        return $store;
    }

    public function acceptStockAdjustment(String $stockId): void
    {
        $this->stock->newQuery()->findOrFail($stockId)->update(["accepted_at" => Carbon::now()]);
    }

    public function rejectStockAdjustment(String $stockId): void
    {
        $this->stock->newQuery()->findOrFail($stockId)->update(["accepted_at" => null]);
    }
}