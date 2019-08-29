<?php namespace App\Providers;

use App\Interfaces\AddressRepositoryContract;
use App\Interfaces\AuthRepositoryContract;
use App\Interfaces\ProductRepositoryContract;
use App\Interfaces\TransactionRepositoryContract;
use App\Repositories\AddressRepository;
use App\Repositories\AuthRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider{
    public function boot(){
        $this->app->bind(AuthRepositoryContract::class,AuthRepository::class);
        $this->app->bind(ProductRepositoryContract::class,ProductRepository::class);
        $this->app->bind(AddressRepositoryContract::class,AddressRepository::class);
        $this->app->bind(TransactionRepositoryContract::class,TransactionRepository::class);
    }
}