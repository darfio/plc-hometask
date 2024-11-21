<?php 
namespace App\Helpers;

use Illuminate\Http\Request;

class Crud{
    protected $model;
    protected $photo;
    protected $plural;
    protected $singular;
    protected $count;
    protected $count_trashed;
    protected $trash=false;
    protected $routes;

    public function __construct($data)
    {
        $this->model = $data['model'];
        $this->plural = $data['plural'] ?? $this->create_plural();
        $this->singular = $data['singular'] ?? $this->create_singular();
        $this->routes = [
            'index' => "$this->plural.index",
            'create' => "$this->plural.create",
            'store'   => "$this->plural.store",
            'edit'   => "$this->plural.edit",
            'update'   => "$this->plural.update",
            'destroy' => "$this->plural.destroy",
            'restore' => "$this->plural.restore"
        ];
    }

    public function query(){
        if($this->model instanceof \Illuminate\Database\Eloquent\Builder){
            return $this->model;
        }
        
        return $this->model::query();
    }

    public function getModelClass(){
        return get_class($this->query()->getModel());
    }

    public function setRoutes($data){
        $this->routes = $data;
    }

    public function getRoutes(){
        return $this->routes;
    }

    public function setRoute($key, $name){
        return $this->routes[$key] = $name;
    }

    public function getRouteName($name){
        return $this->routes[$name];
    }

    public function getIndexDataWithoutItems($trash=null){
        $this->count = $this->query()->count();

        if(method_exists($this->getModelClass(), 'trashed'))
            $this->count_trashed = $this->query()->onlyTrashed()->count();
        $data = [
            'singular' => $this->singular,
            'plural' => $this->plural,
            'count' => $this->count,
            'count_trashed' => $this->count_trashed,
            'routes' => $this->routes,
            'trash' => $trash ? true : false,
        ];
        return $data;
    }   

    public function getIndexData($trash=null){
        $data = $this->getIndexDataWithoutItems($trash);
        $data['items'] = $this->getItems($trash);
        return $data;
    }

    public function getCreateData(){
        $data = [
            'singular' => $this->singular,
            'plural' => $this->plural,
            'routes' => $this->routes,
        ];
        return $data;
    }

    public function getEditData($id){
        // dd($id);
        $item = $this->query()->findOrFail($id);
        $data = [
            'singular' => $this->singular,
            'plural' => $this->plural,
            'item' => $item,
            'routes' => $this->routes,
        ];
        return $data;
    }

    public function store($request){
        $item = $this->query()->create($request->all());
        return $item;
    }

    public function update($request, $id){
        $item = $this->query()->findOrFail($id);
        $item->update($request->all());
        return $item;
    }

    public function destroy($id)
    {
        $item = $this->query()->findOrFail($id);
        $item->delete();
        return $item;
    }

    public function restore($id)
    {
        $item = $this->query()->withTrashed()->find($id);
        $item->restore();
        return $item;
    }

    public function getItems($trash=null){
        if(!isset($trash)){
            $items = $this->query()->get()->sortByDesc('id');
        }  
        else{
            if(method_exists($this->getModelClass(), 'trashed')){
                $items = $this->query()->onlyTrashed()->get()->sortByDesc('id');
                $this->trash = true;                
            }
            else
                $item = [];
        }
        return $items;
    }

    public function getSingular(){
        return $this->singular;
    }

    public function getPlural(){
        return $this->plural;
    }

    private function create_singular(){
        $arr = explode("\\", $this->getModelClass());
        return strtolower(end($arr));
    }

    private function create_plural(){
        $singular = $this->create_singular();
        $last_ch = substr($singular, -1);
        switch($last_ch){
            case 's':
                $plural = $singular."es";
                break;
            case 'y':
                $plural = substr($singular, 0, -1)."ies";
                break;
            default:
                $plural = $singular."s";
        }
        return $plural;
    }
}