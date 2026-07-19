<?php

namespace Tests\Feature;

use App\Models\AuthService;
use App\Models\UserService;
use Mockery;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_expired_token_redirects_to_logout_before_site_lookup(): void
    {
        $site = 'https://client.test/callback?next=/a&mode=sso';
        $authService = Mockery::mock(AuthService::class);
        $authService->shouldReceive('validateUserSiteAccess')->once()->with($site)
            ->andReturn(response()->json(['status' => 'fail'], 401));
        $authService->shouldNotReceive('getSiteInfo');
        $this->app->instance(AuthService::class, $authService);
        $this->app->instance(UserService::class, Mockery::mock(UserService::class));

        $this->withCookie('user_token', 'expired-token')
            ->get('/verify?'.http_build_query(['site' => $site]))
            ->assertRedirect(route('logout', ['site' => $site]));
    }

    public function test_failed_site_lookup_renders_login_without_type_error(): void
    {
        $site = 'https://client.test/callback?next=/a&mode=sso';
        $authService = Mockery::mock(AuthService::class);
        $authService->shouldReceive('validateUserSiteAccess')->once()->with($site)
            ->andReturn(response()->json(['status' => 'success']));
        $authService->shouldReceive('getSiteInfo')->once()->with($site)
            ->andReturn(response()->json(['status' => 'fail'], 404));
        $this->app->instance(AuthService::class, $authService);
        $this->app->instance(UserService::class, Mockery::mock(UserService::class));

        $this->withCookie('user_token', 'token')
            ->get('/verify?'.http_build_query(['site' => $site]))
            ->assertOk()
            ->assertViewIs('contents.login')
            ->assertViewHas('site', ['url' => $site])
            ->assertSee('name="site_destination"', false)
            ->assertSee('value="'.htmlspecialchars($site, ENT_QUOTES, 'UTF-8').'"', false);
    }

    public function test_redirect_to_site_preserves_existing_query_and_fragment(): void
    {
        $site = 'https://client.test/callback?next=/a&mode=sso#result';
        $siteInfo = ['url' => $site, 'name' => 'Client', 'is_mhs' => true];
        $authService = Mockery::mock(AuthService::class);
        $authService->shouldReceive('validateUserSiteAccess')->twice()->with($site)
            ->andReturn(response()->json(['status' => 'success']));
        $authService->shouldReceive('getSiteInfo')->twice()->with($site)
            ->andReturn(response()->json(['status' => 'success', 'data' => ['site' => $siteInfo]]));
        $this->app->instance(AuthService::class, $authService);
        $this->app->instance(UserService::class, Mockery::mock(UserService::class));

        $this->withCookie('user_token', 'token+/=')
            ->get('/verify?'.http_build_query(['site' => $site, 'role' => 'is_mhs+/']))
            ->assertRedirect('https://client.test/callback?next=/a&mode=sso&token=token%2B%2F%3D&role=is_mhs%2B%2F#result');
    }

    public function test_login_script_preserves_complete_destination_url(): void
    {
        $template = file_get_contents(resource_path('views/auth/index.blade.php'));

        $this->assertStringContainsString('const siteDst = new URL(siteParam).href;', $template);
        $this->assertStringNotContainsString('.origin', $template);
        $this->assertStringContainsString('encodeURIComponent(siteDst)', $template);
    }

    public function test_logout_clears_auth_cookies_and_returns_to_login(): void
    {
        $site = 'https://client.test/callback?next=/a&mode=sso';
        $authService = Mockery::mock(AuthService::class);
        $authService->shouldReceive('logout')->once()->andReturn(response()->json(['status' => 'success']));
        $this->app->instance(AuthService::class, $authService);
        $this->app->instance(UserService::class, Mockery::mock(UserService::class));

        $this->withCookie('user_token', 'expired-token')
            ->withCookie('user_roles', 'roles')
            ->get('/logout?'.http_build_query(['site' => $site]))
            ->assertRedirect(route('login', ['site' => $site]))
            ->assertCookieExpired('user_token')
            ->assertCookieExpired('user_roles');
    }
}
