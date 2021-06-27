<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\Asset;
use App\Models\User;
use App\Traits\UploadAble;
use App\Http\Resources\Asset as AssetResource;
use \App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Events\AssetAlert;

class AssetController extends BaseController
{    
    use UploadAble;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {   
            $user = User::find(auth()->user()->id);
            $assets = Asset::all();
            event(new AssetAlert($user));

            return $this->sendResponse(AssetResource::collection($assets), 'Assets retrieved successfully.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetRequest $request)
    {
        
        $input = $request->validated();


        $image = $this->uploadOne($input['picture_path'], 'assets');
        $input['picture_path'] = $image;

        $asset = Asset::create($input);
   
        return $this->sendResponse(new AssetResource($asset), 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = Asset::find($id);
  
        if (is_null($asset)) {
            return $this->sendError('Asset not found.');
        }
   
        return $this->sendResponse(new AssetResource($asset), 'Asset retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssetRequest $request, $id)
    {
        $input = $request->validated();
        
        $asset = Asset::find($id);
        if (is_null($asset)) {
            return $this->sendError('Asset not found.');
        }
        
        if ($request->picture_path) {
            
            $this->deleteOne($asset->picture_path);
            $image = $this->uploadOne($input['picture_path'], 'Assets');
            $input['picture_path'] = $image;
        }
  
        

        $asset->update($input);

        return $this->sendResponse(new AssetResource($asset), 'Asset Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::find($id);
  
        if (is_null($asset)) {
            return $this->sendError('Asset not found.');
        }
        $this->deleteOne($asset->picture_path);

        $asset->delete();
        return $this->sendResponse(new AssetResource($asset), 'Asset Deleted successfully.');
    }
}
