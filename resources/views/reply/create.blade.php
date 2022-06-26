@extends('layouts.core')

@section('container')
    <div class="container reply-container">
        <div class="col-lg-6 mt-5">
            <form class="caption-form-input" method="POST" action="/comment" class="mb-3">
                @csrf
                <div class="mb-3 mt-5">
                    <label for="caption" class="form-label">Reply to {{ $comment->sender_name }}</label>
                    <input id="caption" type="hidden" name="caption" class="@error('caption') is-invalid @enderror" value="{{ old('caption') }}">
                    <trix-editor input="caption"></trix-editor>
                    @error("caption")
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <input type="hidden" name="forum_id" value="{{ $comment->forum_id }}" readonly>
                    <input type="hidden" name="reply_to_id" value="{{ $comment->sender_id }}" readonly>
                </div>
                <button class="btn btn-outline-success" name="submit" type="submit">Send</button>
            </form>
        </div>
    </div>
@endsection