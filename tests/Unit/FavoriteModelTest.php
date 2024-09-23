<?php

namespace Tests\Unit;

use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_can_create_favorite_model(): void
    {
        $model = Favorite::factory()->create();
        $this->assertInstanceOf(Favorite::class, $model);
    }
}
