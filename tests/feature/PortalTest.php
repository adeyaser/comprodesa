<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class PortalTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testHomePageIsAccessible()
    {
        $result = $this->get('/');
        $result->assertStatus(200);
        $result->assertSee('Selamat Datang');
    }

    public function testLoginPageIsAccessible()
    {
        $result = $this->get('login');
        $result->assertStatus(200);
        $result->assertSee('Login');
    }

    public function testAdminDashboardRedirectsToLogin()
    {
        $result = $this->get('admin/dashboard');
        $result->assertRedirect();
    }
}
