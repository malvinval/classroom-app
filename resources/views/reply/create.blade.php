@extends('layouts.core')

@section('container')
    <style>
        trix-toolbar [data-trix-button-group]
        {
            display: none;
        }
    </style>
    <div class="container reply-container">
        <div class="col-lg-6 mt-5">
            <form class="caption-form-input" method="POST" action="/comment" class="mb-3">
                @csrf
                <div class="mb-3 mt-5">
                    <h6 class="text-success">Private comments</h6>
                    <hr>
                    
                    @foreach ($comments as $comment)
                        @if($comment->forum_id == $forum_id)
                            <p><strong>{{ $comment->sender_name }}</strong><small><span class="text-muted"> {{ $comment->created_at }}</span></small></p>
                            <p>{!! $comment->caption !!}</p>
                            @if($comment->sender_id != auth()->user()->id)
                                <input type="hidden" name="forum_id" value="{{ $comment->forum_id }}" readonly>
                                <input type="hidden" name="reply_to_id" value="{{ $comment->sender_id }}" readonly>
                            @endif
                        @endif
                    @endforeach

                    <input id="caption" type="hidden" name="caption" class="@error('caption') is-invalid @enderror" value="{{ old('caption') }}">
                    <trix-editor input="caption"></trix-editor>
                    @error("caption")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                        
                </div>
                <button class="btn btn-outline-success" name="submit" type="submit">Reply</button>
            </form>
        </div>
    </div>
@endsection