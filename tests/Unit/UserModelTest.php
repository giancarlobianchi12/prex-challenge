<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_can_create_user_model(): void
    {
        $model = User::factory()->create();
        $this->assertInstanceOf(User::class, $model);
    }
}
