<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AuthTest extends TestCase
{
   
    public function testRegister()
    {   
        Storage::fake('picture');

        $data = [
            'first_name' => 'Anochie',
            'middle_name' => 'Nwabueze',
            'last_name' => 'Prince',
            'phone_number' => '08161155633',
            'is_disabled' => '2',
            'email' => 'test10@gmail.com',
            'password' => '12345678',
            'picture_url' => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->json('POST',route('api.register'),$data);
        $response->assertStatus(200);

       
    }

    public function testLogin()
    {
        $response = $this->json('POST',route('api.login'),[
            'email' => 'test10@gmail.com',
            'password' => '12345678',
        ]);
        // Determine whether the login is successful and receive response 
        $response->assertStatus(200);
        // Delete users

        User::where('email','test10@gmail.com')->delete();
       
    }
}
