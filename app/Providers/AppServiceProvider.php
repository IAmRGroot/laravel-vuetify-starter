<?php

namespace App\Providers;

use App\Models\Auth\PersonalAccessToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Model::preventLazyLoading();

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
