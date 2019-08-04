<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /** @test */
    public function it_welcome_users_with_nickname()
    {
      $this->get('saludo/david/dave')
          ->assertStatus(200)
          ->assertSee('Bienvenido David, tu apodo es dave');
    }

    /** @test */
    public function it_welcome_users_without_nickname()
    {
      $this->get('saludo/david')
          ->assertStatus(200)
          ->assertSee('Bienvenido David');
    }
}
