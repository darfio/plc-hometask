<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\CrudApi;
use App\Models\Task;
use App\Models\Bug;

class EntityApiController extends Controller
{
    protected $crud;
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

    public function index(Request $request, $type)
    {
        $data = $this->crud->getIndexData($request->trash);
        $data['type'] = $type;
        return response()->json($data);
    }

    public function store(Request $request, $type)
    {
        $item = $this->crud->store($request);
        $data = [
            'data' => $item,
        ];
        return response()->json($data);
    }

    public function show($type, $id){
        try{
            $item = $this->crud->getEditData($id);
        }
        catch (\Exception $e) {
            return $this->notFound();
        }

        $data = [
            'data' => $item,
        ];
        return response()->json($data);
    }

    public function update(Request $request, $type, $id)
    {
        try{
            $item = $this->crud->update($request, $id);
            if(isset($request->status))
                $item->changeStatus($request->status);
        }
        catch (\Exception $e) {
            return $this->notFound();
        }
        $data = [
            'data' => $item,
        ];
        return response()->json($data);
    }

    public function destroy($type, $id)
    {
        try{
            $item = $this->crud->destroy($id);
        }
        catch (\Exception $e) {
            return $this->notFound();
        }
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
            return $this->notFound();
        }
        
        $data = [
            'data' => $item,
        ];
        return response()->json($data);
    }

    private function notFound(){
        return response()->json([
            'success' => false,
            'message' => 'Item not found',
        ], 404);
    }
}
