<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_favorites(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson(route('favorites.store'), [
            'alias' => 'Some alias',
            'gif_id' => 'S2IfEQqgWc0AH4r6Al',
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas(Favorite::class, [
            'user_id' => $user->id,
            'alias' => 'Some alias',
            'gif_id' => 'S2IfEQqgWc0AH4r6Al',
        ]);

        $this->assertDatabaseCount(Favorite::class, 1);
    }
}
