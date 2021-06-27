<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use App\Traits\UploadAble;
use App\Http\Resources\User as UserResource;
use \App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UserAlert;

class UserController extends BaseController
{   
    use UploadAble;
    use Notifiable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //

        $input = $request->validated();


        $image = $this->uploadOne($input['picture_url'], 'users');
        $input['picture_url'] = $image;

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user'] =  $user->toArray();

        $user->notify(new UserAlert());
   
        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $User = User::find($id);
  
        if (is_null($User)) {
            return $this->sendError('User not found.');
        }
   
        return $this->sendResponse(new UserResource($User), 'User retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $input = $request->validated();
        
        $user = User::find($id);
  
        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        unset($input['picture_url']);
        unset($input['password']);

        if ($request->picture_url) {

            $image = $this->uploadOne($request->picture_url, 'users');
            $input['picture_url'] = $image;
        }

        if ($request->password) {

            $input['password'] = bcrypt($request->password);
        }


        $user->update($input);

        return $this->sendResponse(new UserResource($user), 'User Updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $User = User::find($id);
  
        if (is_null($User)) {
            return $this->sendError('User not found.');
        }
        $this->deleteOne($User->picture_url);

        $User->delete();
        return $this->sendResponse(new UserResource($User), 'User Deleted successfully.');
    }
}
