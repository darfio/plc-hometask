<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\CrudApi;
use App\Models\Task;
use App\Models\Bug;

class EntityCommentApiController extends Controller
{
    protected $crud;
    protected $route_names_prefix;
    protected $fields_path;
    protected $types;

    public function __construct(){
        $this->types = [
            'tasks' => Task::class,
            'bugs' => Bug::class,
        ];

        $this->middleware(function ($request, $next) {
            $this->setType($request->type);
            return $next($request);
        });
    }

    public function setType($type)
    {
        $this->crud = new CrudApi([
            'model'=>$this->types[$type],
            'type' => $type,
        ]);
    }

    public function index(Request $request, $type, $id)
    {
        // $data = $this->crud->getIndexData($request->trash);
        $data = $this->crud->getEditData($id);
        $data['type'] = $type;
        $data['comments'] = $type;
        return response()->json($data);
    }

    public function store(Request $request, $type, $entity_id)
    {
        $data = $this->crud->getEditData($entity_id);
        $data['item']->comments()->create([
            'text' => $request->text
        ]);
        $data['item']->refresh();
        $data = [
            'data' => $data,
        ];
        return response()->json($data);
    }

    public function show($type, $id){
        try{
            $data = $this->crud->getEditData($id);
            $data['comments'] = $data['item']->comments;
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
            ], 404);
        }
        $data = [
            'data' => $data,
        ];
        return response()->json($data);
    }

    public function update(Request $request, $type, $id)
    {
        $item = $this->crud->update($request, $id);
        if(isset($request->status))
            $item->changeStatus($request->status);
        $data = [
            'data' => $item,
        ];
        return response()->json($data);
    }

    public function destroy($type, $id){
        $item = $this->crud->destroy($id);
        $data = [
            'data' => $item,
        ];
        return response()->json($data);
    }

    public function restore($type, $id){
        try{
            $item = $this->crud->restore($id);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
            ], 404);
        }
        
        $data = [
            'data' => $item,
        ];
        return response()->json($data);
    }

    private function getResult(){

    }
}
