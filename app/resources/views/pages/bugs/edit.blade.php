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

                @include($fields_path)

                <button class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
