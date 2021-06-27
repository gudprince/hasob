<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadAble;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UserAlert;
use App\Events\RegisterAlert;

class RegisterController extends BaseController
{   
    use UploadAble, Notifiable;

    /**
     * Register api
     *  @param  \App\Http\Requests\StorePostRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(StoreUserRequest $request)
    {  
        /** StoreUserRequest class automatically returns the validation error as json */

        $input = $request->validated();


        $image = $this->uploadOne($input['picture_url'], 'users');
        $input['picture_url'] = $image;

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user'] =  $user->toArray();
        
        event(new RegisterAlert($user));
        
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['user'] =  Auth()->user()->toArray();
            
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'incorrect email/password']);
        } 
    }
}
