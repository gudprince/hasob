<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AssetTest extends TestCase
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
            'email' => 'test2@gmail.com',
            'password' => '12345678',
            'picture_url' => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->json('POST',route('api.register'),$data);
        $response->assertStatus(200);
    }

    protected function testcreate()
    {
        $data = $this->json('POST',route('api.login'),[
            'email' => 'test2@gmail.com',
            'password' => '12345678',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$data['data']['token'],
        ])->json('POST',url('api/assets'),[
            'serial_number'  => '6',
            'description'  => 'testing1',
            'fix_or_movable'  => 'testing',
            'picture_path'  => UploadedFile::fake()->image('avatar.jpg'),
            'purchase_date'  => 'testing',
            'start_use_date'  => 'testing',
            'purchase_price'  => 200,
            'warranty_expire_date'  => 'testing',
            'degradation_in_years'  => 1992,
            'current_value_in_naira'  => 3000,
            'location'  => 'testing',
        ]);
        $response->assertStatus(200);
        return $response['data']['id'];
       
       
    }

    public function testAll(){
    
        $data = $this->json('POST',route('api.login'),[
            'email' => 'test2@gmail.com',
            'password' => '12345678',
        ]);
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $data['data']['token'],
        ])->json('GET',url('api/assets/'));
        $response->assertStatus(200);

    }

    public function testUpdate(){

        $data = $this->json('POST',route('api.login'),[
            'email' => 'test2@gmail.com',
            'password' => '12345678',
        ]);
        $token = $data['data']['token'];
        $id =  $this->testcreate();
       
        // Call routing and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',url('api/assets', ['id' => $id]),[
            'serial_number'  => '6',
            'description'  => 'testingupdate2',
            'fix_or_movable'  => 'testing',
            'picture_path'  => UploadedFile::fake()->image('avatar.jpg'),
            'purchase_date'  => 'testing',
            'start_use_date'  => 'testing',
            'purchase_price'  => 200,
            'warranty_expire_date'  => 'testing',
            'degradation_in_years'  => 1992,
            'current_value_in_naira'  => 30,
            'location'  => 'testing',
        ]);
       
        $response->assertStatus(200);
        $this->assertArrayHasKey('data',$response);
    }

    public function testDelete(){
    
        $data = $this->json('POST',route('api.login'),[
            'email' => 'test2@gmail.com',
            'password' => '12345678',
        ]);
        $id =  $this->testcreate(); 
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $data['data']['token'],
        ])->json('delete',url('api/assets', ['id' => $id]));
        $response->assertStatus(200);
        User::where('email','test2@gmail.com')->delete();

    }

       
}
