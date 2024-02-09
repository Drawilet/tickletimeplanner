<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use app\Models\Tenant;


class LoginRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testIncorrectRegistration()
    {
        //Registro incorrecto
        $response = $this->post(route('register'), [
            'name' => 'Test',
            'email' => 'notanemail',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('users', [
            'email' => 'notanemail',
        ]);
    }

    public function testCorrectRegistration()
    {
        //Registro correcto
        $response = $this->post(route('register'), [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'email_verified_at' => now(),
            'current_team_id' => null,
            'profile_photo_path' => null,
            "tenant_id" => '1',

        ]);

        $response->assertRedirect(route('dashboard.show'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
    public function testAlreadyRegistered()
    {
        //Usuario ya registrado
        $user = User::factory()->create();
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors('email');
    }
    public function testStartSession()
    {
        //Iniciar sesión
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertRedirect(route('dashboard.show'));
    }
    public function testIncorrectStartSession()
    {
        //session con datos incorrectos
        $session = $this->post(route('login'), [
            'email' => 'dhasvfy@example.com',
            'password' => 'password',

        ]);
        $session->assertSessionHasErrors('email', 'password');
    }
    public function test_dashboard_not_already_session()
    {
        //dashboard sin sesión
        $response = $this->get(route('dashboard.show'));
        $response->assertRedirect(route('login'));
    }
}