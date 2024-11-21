<?php 
namespace App\Helpers;

use Illuminate\Http\Request;

class CrudApi{
    protected $model;
    protected $count;
    protected $count_trashed;
    protected $trash=false;
    protected $type;

    public function __construct($data)
    {
        $this->model = $data['model'];
        $this->type = $data['type'];
    }

    public function query(){
        return $this->model::query()->with(['comments']);
    }

    public function getModelClass(){
        return get_class($this->query()->getModel());
    }

    public function getIndexDataWithoutItems($trash=null){
        $this->count = $this->query()->count();

        if(method_exists($this->getModelClass(), 'trashed'))
            $this->count_trashed = $this->query()->onlyTrashed()->count();
        $data = [
            'count' => $this->count,
            'count_trashed' => $this->count_trashed,
            'trash' => $trash ? true : false,
            'type' => $this->type,
        ];
        return $data;
    }   

    public function getIndexData($trash=null){
        $data = $this->getIndexDataWithoutItems($trash);
        $data['items'] = $this->getItems($trash);
        return $data;
    }

    public function getEditData($id){
        $item = $this->query()->findOrFail($id);
        $data = [
            'type' => $this->type,
            'item' => $item,
        ];
        return $data;
    }

    public function store($request){
        $item = $this->query()->create($request->all());
        $data = [
            'type' => $this->type,
            'item' => $item,
        ];
        return $data;
    }

    public function update($request, $id){
        $item = $this->query()->findOrFail($id);
        $updated = $item->update($request->all());
        $data = [
            'updated' => $updated,
            'type' => $this->type,
            'item' => $item,
        ];
        return $data;
    }

    public function destroy($id)
    {
        $item = $this->query()->findOrFail($id);
        $deleted = $item->delete();
        return [
            'deleted' => $deleted,
            'type' => $this->type,
            'item' => $item,
        ];
    }

    public function restore($id)
    {
        $item = $this->query()->onlyTrashed()->findOrFail($id);
        $item->restore();
        return $item;
    }

    public function getItems($trash=null){
        if(!isset($trash)){
            $items = $this->query()->get();
        }  
        else{
            if(method_exists($this->getModelClass(), 'trashed')){
                $items = $this->query()->onlyTrashed()->get();
                $this->trash = true;                
            }
            else
                $item = [];
        }
        return $items;
    }

}