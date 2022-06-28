<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>{{ env("APP_NAME") }}</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;300;400;700&display=swap" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
            <link rel="stylesheet" href="/css/single-forum/style.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
            <link rel="stylesheet" type="text/css" href="/css/trix.css">
            <style>
                trix-toolbar [data-trix-button-group]
                {
                    display: none;
                }
            </style>
            <script type="text/javascript" src="/js/trix.js"></script>
    </head>
    <body>
        @include('partials.navbar')
        <div class="container single-forum-container">
            @foreach($classroom as $c)
                <div class="single-forum-detail-header-container">
                    <h1 class="display-5 fw-bold text-success">{{ $c->name }}</h1>
                    <p class="col-md-8 fs-6 text-muted">{{ $c->description }}</p>
                    <hr>
                </div>
        
                <div class="single-forum-detail-body-container mt-3">
                    <div class="mb-3">
                        <p>{!! $specified_forum->caption !!}</p>
                        
                        @if($teacher_file_attachment->count())
                            @foreach ($teacher_file_attachment as $file)
                                <a href="/storage/{{ $file->file }}">{{ $file->original_file_name }}</a>
                            @endforeach
                        @endif
                    </div>
        
                    @if($creator_id == auth()->user()->id)
                        <a href="/sa/{{ $specified_forum->id }}" class="btn btn-success mt-3">Check</a>
                    @else
                        @if($student_file_attachment->count())
                            @foreach ($student_file_attachment as $file)
                                <div class="card">
                                    <div class="card-body">
                                        <p class="text-muted">Your attachment : </p>
                                        <a href="/storage/{{ $file->file }}" download="{{ $file->original_file_name }}">{{ $file->original_file_name }}</a>
                                    </div>
                                </div>
                                <form action="/sa/{{ $file->id }}" method="POST">
                                    @csrf
                                    @method("delete")
                                    <button type="submit" name="submit" onclick="return confirm('Are you sure want to delete this assignment ?');" class="btn btn-danger mt-3">Cancel</button>
                                </form>
                            @endforeach
                        @else
                            <form method="POST" action="/sa" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 w-50">
                                    <input class="form-control-sm @error('student_file_attachment') is-invalid @enderror" type="file" id="student_file_attachment" name="student_file_attachment">
                    
                                    @error("student_file_attachment")
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
        
                                <input type="hidden" name="forum_id" value="{{ $specified_forum->id }}" readonly>
        
                                <button type="submit" name="submit" class="btn btn-success mt-3">Submit</button>
                            </form>
                        @endif
                    @endif
                </div>
        
                <div class="col-lg-6 mt-5">
                    <div class="comments-container">
                        <h6 class="text-success">Private comments</h6>
                        <hr>
                        <div class="single-comment-identity-container">
                            @if($teacher_view_comments->count() == 0)
                                <p class="text-muted">No comments yet.</p>
                            @endif
                            @if(auth()->user()->id == $specified_forum->creator_id )
                                @foreach ($teacher_view_comments as $comment)
                                    <div class="forum-comment-header d-flex justify-content-between">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center my-1">
                                                <a class="text-decoration-none" href="/comment/{{ $specified_forum->id }}/{{ $comment->sender_id }}">{{ $comment->sender_name }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($student_view_comments as $comment)
                                    @if($comment->forum_id == $specified_forum->id)
                                        <p><strong>{{ $comment->sender_name }}</strong><small><span class="text-muted"> {{ $comment->created_at }}</span></small></p>
                                        <p>{!! $comment->caption !!}</p>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <form class="caption-form-input" method="POST" action="/comment" class="mb-3">
                        @csrf
                        <div class="mb-3 mt-5">
                            <label for="caption" class="form-label">Add comment to {{ $specified_forum->creator_id == auth()->user()->id ? "all students" : $specified_forum->creator_name }}</label>
                            <input id="caption" type="hidden" name="caption" class="@error('caption') is-invalid @enderror" value="{{ old('caption') }}">
                            <trix-editor input="caption"></trix-editor>
                            @error("caption")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <input type="hidden" name="forum_id" value="{{ $specified_forum->id }}" readonly>
                        </div>
                        <button class="btn btn-outline-success" name="submit" type="submit">Send</button>
                    </form>
                </div>

            @endforeach
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
        <script>
            // function toggleReplyInput() {
            //     let replyInput = document.querySelector(".reply-input");
            //     replyInput.classList.toggle("d-none");
            // }
        </script>
    </body>
</html>