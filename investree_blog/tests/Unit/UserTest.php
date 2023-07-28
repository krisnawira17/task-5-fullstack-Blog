<?php

namespace Tests\Unit;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class UserTest extends TestCase
{
    public function test_user()
    {
        $user = (object) User::factory()->definition();

        $user = User::create([
            'name' =>  $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);
        
        $this->assertDatabaseHas('users',[
            'name' =>  $user->name,
            'email' => $user->email,
        ]);
        
    }
}
