<?php

namespace App\Providers;

use App\Http\Repositories\Post\AuthRepositoryInterface;
use App\Repositories\Auth\AuthEloquentRepository;
use App\Repositories\Issue\IssueEloquentRepository;
use App\Repositories\Issue\IssueRepositoryInterface;
use App\Repositories\Type\TypeEloquentRepository;
use App\Repositories\Type\TypeRepositoryInterface;
use App\Services\Auth\AuthServiceImplement;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Issue\IssueServiceImplement;
use App\Services\Issue\IssueServiceInterface;
use App\Services\Type\TypeServiceImplement;
use App\Services\Type\TypeServiceInterface;
use App\Repositories\Category\CategoryEloquentRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Role\RoleEloquentRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Status\StatusEloquentRepository;
use App\Repositories\Status\StatusRepositoryInterface;
use App\Services\Category\CategoryServiceInterface;
use App\Services\Category\CategoryServiceImplement;
use App\Services\Role\RoleServiceImplement;
use App\Services\Role\RoleServiceInterface;
use App\Services\Status\StatusServiceImplement;
use App\Services\Status\StatusServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $this->app->singleton(
            AuthRepositoryInterface::class,
            AuthEloquentRepository::class
        );

        $this->app->singleton(
            AuthServiceInterface::class,
            AuthServiceImplement::class
        );

        $this->app->singleton(
            TypeRepositoryInterface::class,
            TypeEloquentRepository::class
        );

        $this->app->singleton(
            TypeServiceInterface::class,
            TypeServiceImplement::class
        );

        $this->app->singleton(
            IssueRepositoryInterface::class,
            IssueEloquentRepository::class
        );

        $this->app->singleton(
            RoleServiceInterface::class,
            RoleServiceImplement::class
        );

        $this->app->singleton(
            RoleRepositoryInterface::class,
            RoleEloquentRepository::class
        );

        $this->app->singleton(
            StatusServiceInterface::class,
            StatusServiceImplement::class
        );

        $this->app->singleton(
            StatusRepositoryInterface::class,
            StatusEloquentRepository::class
        );

        $this->app->singleton(
            IssueServiceInterface::class,
            IssueServiceImplement::class
        );
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryEloquentRepository::class
        );

        $this->app->singleton(
            CategoryServiceInterface::class,
            CategoryServiceImplement::class
        );
    }
}
