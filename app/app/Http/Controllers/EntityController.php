<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Crud;

class EntityController extends Controller
{
    protected $crud;
    protected $route_names_prefix;
    protected $fields_path;
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;

        $this->crud = new Crud([
            'model'=>$model,
        ]);

        $this->crud->setRoutes([
            'index' => "{$this->route_names_prefix}.index",
            'create' => "{$this->route_names_prefix}.create",
            'store'   => "{$this->route_names_prefix}.store",
            'edit'   => "{$this->route_names_prefix}.edit",
            'update'   => "{$this->route_names_prefix}.update",
            'destroy' => "{$this->route_names_prefix}.destroy",
            'restore' => "{$this->route_names_prefix}.restore",
        ]);
    }

    public function index(Request $request){
        $data = $this->crud->getIndexData($request->trash);
        $data['title'] = strtoupper($this->crud->getPlural());
        if($request->trash){
            $data['title'] = strtoupper($this->crud->getPlural()).' (trash)';
        }
        return view("pages.{$this->crud->getPlural()}.index", $data);
    }

    public function create(){
        $data = $this->crud->getCreateData();
        // $data['statuses'] = $this->model::getStatuses();
        $data['fields_path'] = $this->fields_path;
        $data['title'] = 'Task create';
        return view("pages.{$this->crud->getPlural()}.create", $data);
    }

    public function store(Request $request){
        $this->crud->store($request);
        return redirect()->route($this->crud->getRouteName('index'));
    }

    public function edit($id){
        $data = $this->crud->getEditData($id);
        $data['statuses'] = $this->model::getStatuses();
        $data['fields_path'] = $this->fields_path;
        $data['title'] = 'Task edit';
        return view("pages.{$this->crud->getPlural()}.edit", $data);
    }

    public function update($id, Request $request){
        $item = $this->crud->update($request, $id);
        $item->changeStatus($request->status);
        return redirect()->back();
    }

    public function destroy($id){
        $item = $this->crud->destroy($id);
        return redirect()->back();
    }

    public function restore($id){
        $item = $this->crud->restore($id);
        return redirect()->back();
    }
}
