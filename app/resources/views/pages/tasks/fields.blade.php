<div class="form-group">
    <label>Title:</label>
    <input class="form-control" name="title" value="{{$item->title ?? old('title')}}" />
</div>

<div class="form-group">
    <label>Description:</label>
    <textarea class="form-control" rows="4">{{$item->assignee ?? old('assignee')}}</textarea>
</div>

<div class="form-group">
    <label>Creator:</label>
    <input class="form-control" name="creator" value="{{$item->creator ?? old('creator')}}" />
</div>

<div class="form-group">
    <label>Tester:</label>
    <input class="form-control" name="tester" value="{{$item->tester ?? old('tester')}}" />
</div>

<div class="form-group">
    <label>Assignee:</label>
    <input class="form-control" name="assignee" value="{{$item->assignee ?? old('assignee')}}" />
</div>

@if(isset($item))
<div class="form-group">
    <label>Status:</label>
    <select class="form-control" name="status">
        <option>--- Select ---</option>
        @foreach($statuses as $status)
            <option value="{{$status}}" {{$status == $item->status ? 'selected' : ''}}>{{$status}}</option>
        @endforeach
    </select>
</div>
@endif