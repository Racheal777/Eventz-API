<?php

namespace Tests;

use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function authenticate($user = null)
    {
        $user = $user ?? User::factory()->create();
        Passport::actingAs($user);

        return $user;
    }
}
