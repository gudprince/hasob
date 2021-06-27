<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AssetAsignTest extends TestCase
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
            'email' => 'test4@gmail.com',
            'password' => '12345678',
            'picture_url' => UploadedFile::fake()->image('avatar.jpg')
        ];
        $response = $this->json('POST',route('api.register'),$data);
        $response->assertStatus(200);
    }

    protected function testcreate()
    {
        $data = $this->json('POST',route('api.login'),[
            'email' => 'test4@gmail.com',
            'password' => '12345678',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$data['data']['token'],
        ])->json('POST',url('api/asset-assignment'),[
            'asset_id'  => 2,
            'assignment_date'  => 'testing',
            'status'  => 1,
            'is_due'  => 3,
            'assigned_user_id'  => 4,
            'assigned_by'  => 'prince',
        ]);
        $this->assertArrayHasKey('data',$response);
        $response->assertStatus(200);
        return $response['data']['id'];
       
       
    }

    public function testAll(){
    
        $data = $this->json('POST',route('api.login'),[
            'email' => 'test4@gmail.com',
            'password' => '12345678',
        ]);
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $data['data']['token'],
        ])->json('GET',url('api/asset-assignment'));
        $response->assertStatus(200);
        $this->assertArrayHasKey('data',$response);


    }

    public function testUpdate(){

        $data = $this->json('POST',route('api.login'),[
            'email' => 'test4@gmail.com',
            'password' => '12345678',
        ]);
        $token = $data['data']['token'];
        $id =  $this->testcreate();
       
        // Call routing and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',url('api/asset-assignment', ['id' => $id]),[
            'asset_id'  => 1,
            'assignment_date'  => 'testing',
            'status'  => 1,
            'is_due'  => 3,
            'assigned_user_id'  => 4,
            'assigned_by'  => 'John',
        ]);
       
        $response->assertStatus(200);
        $this->assertArrayHasKey('data',$response);
    }

    public function testDelete(){
    
        $data = $this->json('POST',route('api.login'),[
            'email' => 'test4@gmail.com',
            'password' => '12345678',
        ]);
        $id =  $this->testcreate(); 
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $data['data']['token'],
        ])->json('delete',url('api/asset-assignment', ['id' => $id]));
        $response->assertStatus(200);
        User::where('email','test4@gmail.com')->delete();

    }
}
