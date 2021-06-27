<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class VendorTest extends TestCase
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
            'email' => 'test3@gmail.com',
            'password' => '12345678',
            'picture_url' => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->json('POST',route('api.register'),$data);
        $response->assertStatus(200);
    }

    protected function testcreate()
    {
        $data = $this->json('POST',route('api.login'),[
            'email' => 'test3@gmail.com',
            'password' => '12345678',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$data['data']['token'],
        ])->json('POST',url('api/vendors'),[
            'name'  => 'mtn',
            'category'  => 'tech',
        ]);
        $response->assertStatus(200);
        $this->assertArrayHasKey('data',$response);
        return $response['data']['id'];
       
       
    }

    public function testAll(){
    
        $data = $this->json('POST',route('api.login'),[
            'email' => 'test3@gmail.com',
            'password' => '12345678',
        ]);
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $data['data']['token'],
        ])->json('GET',url('api/vendors/'));
        $response->assertStatus(200);
        $this->assertArrayHasKey('data',$response);
     

    }

    public function testUpdate(){

        $data = $this->json('POST',route('api.login'),[
            'email' => 'test3@gmail.com',
            'password' => '12345678',
        ]);
        $token = $data['data']['token'];
        $id =  $this->testcreate();
       
        // Call routing and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',url('api/vendors', ['id' => $id]),[
            'name'  => 'glo',
            'category'  => 'tech',
        ]);
       
        $response->assertStatus(200);
        $this->assertArrayHasKey('data',$response);
    }

    public function testDelete(){
    
        $data = $this->json('POST',route('api.login'),[
            'email' => 'test3@gmail.com',
            'password' => '12345678',
        ]);
        $id =  $this->testcreate(); 
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $data['data']['token'],
        ])->json('delete',url('api/vendors', ['id' => $id]));
        $response->assertStatus(200);
        $this->assertArrayHasKey('data',$response);
        User::where('email','test3@gmail.com')->delete();

    }
}
