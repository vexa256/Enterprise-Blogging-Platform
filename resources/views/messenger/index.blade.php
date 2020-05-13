<div class="modal-wrapper messeges-index">

    @foreach($threads->items as $message)

    <div class="message">
        <a class="pull-left" href="#">
            <img src="{{ makepreview($message->user->icon, 'b', 'members/avatar') }}"
                 alt="{{ $message->user->name }}" class="img-circle">
        </a>
        <div class="media-body">
            <h5 class="media-heading">{{ $message->user->name }}</h5>
            <p>{{ $message->body }}</p>
            <div class="text-muted">
                <small>Posted {{ $message->created_at->diffForHumans() }}</small>
            </div>
        </div>
    </div>

    @endforeach
</div>