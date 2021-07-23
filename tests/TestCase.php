<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Response;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        abort_if(
            method_exists($this, 'usingInMemoryDatabase') && ! $this->usingInMemoryDatabase(),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            'Config uses real database instead of in-memory sqlite.'
        );

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }
}
