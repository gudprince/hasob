<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\Vendor;
use App\Traits\UploadAble;
use App\Http\Resources\Vendor as VendorResource;
use \App\Http\Requests\StoreVendorRequest;
use App\Events\VendorAlert;

class VendorController extends BaseController
{    
    use UploadAble;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();
    
        return $this->sendResponse(VendorResource::collection($vendors), 'Vendors retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVendorRequest $request)
    {
        
        $input = $request->validated();

        $record = Vendor::create($input);
        
        event(new VendorAlert(Auth()->user()));
        
        return $this->sendResponse(new VendorResource($record), 'Vendor created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::find($id);
  
        if (is_null($vendor)) {
            return $this->sendError('Record not found.');
        }
   
        return $this->sendResponse(new VendorResource($vendor), 'vendor retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVendorRequest $request, $id)
    {
        $input = $request->validated();
        
        $vendor =  Vendor::find($id);
        if (is_null($vendor)) {
            return $this->sendError('Vendor not found.');
        }
        
        $vendor->update($input);

        return $this->sendResponse(new  VendorResource($vendor), 'Vendor Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);
  
        if (is_null($vendor)) {
            return $this->sendError('Vendor not found.');
        }

        $vendor->delete();
        return $this->sendResponse(new  VendorResource($vendor), 'Vendor Deleted successfully.');
    }
}
