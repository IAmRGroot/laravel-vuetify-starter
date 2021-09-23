<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        abort_if(
            ! $this->usingInMemoryDatabase(),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            'Config uses real database instead of in-memory sqlite.'
        );

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }
}
