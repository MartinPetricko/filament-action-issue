<div>
    @foreach($this->comments as $comment)
        <div>
            {{ $comment->message }}
        </div>
    @endforeach
</div>
