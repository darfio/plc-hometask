
<form action="{{route('comments.store')}}" method="POST">
    @csrf
    <input type="hidden" name="object_id" value="{{$object_id}}">
    <input type="hidden" name="object_type" value="{{$object_type}}">
    <div class="form-group">
        <label>Comment:</label>
        <textarea name="text" class="form-control" rows="4"></textarea>
    </div>

    <button class="btn btn-success">Comment</button>
</form>

<div class="comments">
    <label>Comments:</label>
    @foreach($comments as $comment)
        <div class="comment well">
            <p>{{$comment->id}}: {{$comment->text}}</p>

            <div class="replies well" style="margin-left: 25px">
                <label>Replies:</label>
                @foreach($comment->comments as $reply)
                    <p>{{$reply->id}}: {{$reply->text}}</p>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
