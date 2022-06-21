<?php
     
namespace App\Http\Controllers\API;
     
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AppResource;
use App\Models\App;

class AppController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $app = App::all();
      
        return $this->sendResponse(AppResource::collection($app), 'App retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'name_app' => 'required',
            'url' => 'required',
            'foto' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $app = App::create($input);
     
        return $this->sendResponse(new AppResource($app), 'App created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $app = App::find($id);
    
        if (is_null($app)) {
            return $this->sendError('App not found.');
        }
     
        return $this->sendResponse(new AppResource($app), 'App retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, App $app)
    {
        $input = $request->all();
     
        $validator = Validator::make($input, [
            'name_app' => 'required',
            'url' => 'required',
            'foto' => 'required'
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $app->name_app = $input['name_app'];
        $app->url = $input['url'];
        $app->foto = $input['foto'];
        $app->save();
     
        return $this->sendResponse(new AppResource($app), 'App updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(App $app)
    {
        $app->delete();
     
        return $this->sendResponse([], 'App deleted successfully.');
    }
}