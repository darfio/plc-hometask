@extends('layouts.app')

@section('content')
<div class="container-fluid text-center">    
    <div class="row content">
        
        @include('inc.nav')

        <div class="col-sm-8 text-left"> 
            <h1>{{$title}}</h1>
        
            <div class="row">
                <div class="col-sm-6">
                    <form action="{{route($routes['update'], $item)}}" method="POST">
                        @csrf
                        @method('PUT')
                        @include($fields_path)
                    </form>
                </div>
                <div class="col-sm-6">
                    @include('inc.comments', [
                        'object_id' => $item->id,
                        'object_type' => class_basename($item),
                        'comments' => $item->comments,
                    ])
                </div>
            </div>

            <button class="btn btn-success">Update</button>
            
        </div>
    </div>
</div>
@endsection
