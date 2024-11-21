@extends('layouts.app')

@section('content')
<div class="container-fluid text-center">    
    <div class="row content">
        
        @include('inc.nav')

        <div class="col-sm-8 text-left"> 
            <h1>{{$title}}</h1>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comment</th>
                        <th>Replies</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        @if(!$item->is_reply)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->text}}</td>
                                <td>
                                    @foreach($item->comments as $reply)
                                        <div>{{$reply->id}} - {{$reply->text}}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @if($trash)
                                        <form action="{{route($routes['restore'], $item)}}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-success">Restore</button>
                                        </form>
                                    @else
                                        <a href="{{route($routes['edit'], $item)}}" class="btn btn-success">Edit</a>
                                        <form action="{{route($routes['destroy'], $item)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
