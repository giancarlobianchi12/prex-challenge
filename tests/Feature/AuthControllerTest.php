<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_auth(): void
    {
        $this->createPersonalClient();
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSuccessful();
    }

    public function test_user_can_not_auth_password_wrong(): void
    {
        $this->createPersonalClient();

        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => '12346578',
        ]);

        $response->assertUnauthorized();
    }

    public function test_user_can_get_me()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson(route('auth.me'));

        $response->assertSuccessful();
    }

    public function test_user_unauthorized_can_not_get_me()
    {
        $response = $this->getJson(route('auth.me'));

        $response->assertUnauthorized();
    }

    private function createPersonalClient()
    {
        Passport::$hashesClientSecrets = false;

        $this->artisan(
            'passport:client',
            ['--name' => config('app.name'), '--personal' => null]
        );

        return DB::table('oauth_clients')
            ->where('personal_access_client', '=', true)
            ->first();
    }
}
