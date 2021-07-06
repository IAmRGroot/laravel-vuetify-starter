<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Library\Maintenance\ControllerBase;
use Illuminate\Support\Facades\Route;

class MaintenanceController extends Controller
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function maintenance(): array
    {
        return array_map(
            fn (ControllerBase $controller): array => $controller->vueData(),
            self::getControllers()
        );
    }

    public static function routes(): void
    {
        Route::prefix('maintenance')
            ->name('maintenance.')
            ->group(static function (): void {
                Route::get('', [MaintenanceController::class, 'maintenance']);

                foreach (self::getControllers() as $controller) {
                    $controller->routes();
                }
            });
    }

    /**
     * @return ControllerBase[]
     */
    private static function getControllers(): array
    {
        return [
            new UserController(),
            new RoleController(),
        ];
    }
}
