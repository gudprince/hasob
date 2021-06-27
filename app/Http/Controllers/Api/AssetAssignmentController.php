<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\AssetAssignment;
use App\Traits\UploadAble;
use App\Http\Resources\AssetAssignment as AssetAssignResource;
use \App\Http\Requests\AssignmentRequest;
use App\Events\AssignmentAlert;


class AssetAssignmentController extends BaseController
{   
    use UploadAble;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = AssetAssignment::all();
    
        return $this->sendResponse(AssetAssignResource::collection($records), 'Records retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentRequest $request)
    {   
        /** AssignmentRequest will automatically return all errors if validation failed */

        $input = $request->validated();
        $record = AssetAssignment::create($input);

        event(new AssignmentAlert(Auth()->user()));
   
        return $this->sendResponse(new AssetAssignResource($record), 'record created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = AssetAssignment::find($id);
  
        if (is_null($record)) {
            return $this->sendError('Record not found.');
        }
   
        return $this->sendResponse(new AssetAssignResource($record), 'Record retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssignmentRequest $request, $id)
    {
        $input = $request->validated();
        
        $record =  AssetAssignment::find($id);
        if (is_null($record)) {
            return $this->sendError('Record not found.');
        }
        
        $record->update($input);

        return $this->sendResponse(new  AssetAssignResource($record), 'Record Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = AssetAssignment::find($id);
  
        if (is_null($record)) {
            return $this->sendError('Record not found.');
        }

        $record->delete();
        return $this->sendResponse(new  AssetAssignResource($record), 'Record Deleted successfully.');
    }
}
