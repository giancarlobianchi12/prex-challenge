<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\GiphyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Mockery;
use Tests\TestCase;

class GifControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_user_can_search_gifs(): void
    {
        $json = file_get_contents(base_path('tests/fixtures/gifs.json'));
        $giphyResponse = json_decode($json, true);

        $giphyServiceMock = Mockery::mock(GiphyService::class);

        $giphyServiceMock->shouldReceive('searchGifs')
            ->once()
            ->with('hello', 10, 0)
            ->andReturn($giphyResponse);

        $this->app->instance(GiphyService::class, $giphyServiceMock);

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson(route('gifs.search', [
            'query' => 'hello',
            'limit' => 10,
            'offset' => 0,
        ]));

        $response->assertSuccessful()
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->count('data', 10)
                    ->etc()
            );
    }

    public function test_unauthorized_user_can_not_search_gifs()
    {
        $response = $this->getJson(route('gifs.search', [
            'query' => 'hello',
            'limit' => 10,
            'offset' => 0,
        ]));

        $response->assertUnauthorized();
    }

    public function test_auth_user_can_search_gif_by_id(): void
    {
        $json = file_get_contents(base_path('tests/fixtures/singleGif.json'));
        $giphyResponse = json_decode($json, true);

        $giphyServiceMock = Mockery::mock(GiphyService::class);

        $giphyServiceMock->shouldReceive('getGifById')
            ->once()
            ->andReturn($giphyResponse);

        $this->app->instance(GiphyService::class, $giphyServiceMock);

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson(route('gifs.show', [
            'id' => 'S2IfEQqgWc0AH4r6Al',
        ]));

        $response->assertSuccessful()
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data')
                    ->has('data.type')
                    ->etc()
            );
    }

    public function test_unauthorized_user_can_not_search_gif_by_id()
    {
        $response = $this->getJson(route('gifs.show', [
            'id' => 'S2IfEQqgWc0AH4r6Al',
        ]));

        $response->assertUnauthorized();
    }
}
