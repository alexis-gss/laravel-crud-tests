<?php

namespace Tests\Back;

use App\Models\User as AuthModel;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /** @return void */
    public function testGuestCanViewLoginForm(): void
    {
        $response = $this->get(route(config('unit-tests.route.prefix') . 'login'));
        $response->assertSuccessful();
        $response->assertViewIs(config('unit-tests.view.prefix') . 'auth.login');
    }

    /** @return void */
    public function testGuestCannotAccessAdminDashboard(): void
    {
        $response = $this->get(route(config('unit-tests.route.prefix') . config('unit-tests.view.name-homepage')));
        $response->assertRedirect(route(config('unit-tests.route.prefix') . 'login'));
    }

    /** @return void */
    public function testUserCanAccessAdminDashboard(): void
    {
        // @phpstan-ignore-next-line
        $authModel = AuthModel::factory()->create();
        $response  = $this->actingAs($authModel, 'backend')
            ->get(route(config('unit-tests.route.prefix') . config('unit-tests.view.name-homepage')));
        $response->assertSuccessful();
        $response->assertViewIs(config('unit-tests.view.prefix') . 'pages.' . config('unit-tests.view.name-homepage'));
    }

    /** @return void */
    public function testUserCannotViewLoginFormWhenAuthenticated(): void
    {
        // @phpstan-ignore-next-line
        $authModel = AuthModel::factory()->make();
        $response  = $this->actingAs($authModel, 'backend')->get(route(config('unit-tests.route.prefix') . 'login'));
        $response->assertStatus(302);
    }
}
