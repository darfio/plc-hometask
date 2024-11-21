@extends('layouts.app')

@section('content')
<div class="container-fluid text-center">    
    <div class="row content">
        
        @include('inc.nav')

        <div class="col-sm-8 text-left"> 
            <h1>{{$title}}</h1>
            
            <form action="{{route($routes['update'], $item)}}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-sm-6">
                        @include($fields_path)
                    </div>
                    <div class="col-sm-6">
                        @include('inc.comments', ['comments' => $item->comments])
                    </div>
                </div>

                <button class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
