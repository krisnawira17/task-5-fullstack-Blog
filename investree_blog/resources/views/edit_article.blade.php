@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Post</h1>
        @if ($errors->any())
            <div class="alert alert-danger mt-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('articles.update', ['id' => $article->id]) }}" enctype="multipart/form-data">
            @csrf
        <div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId"
                        placeholder="" value="{{old('title', $article->title)}}">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" name="content" id="content" rows="20" style="resize: none">{{old('content', $article->content)}}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/jpeg, image/png"
                        aria-describedby="fileHelpId">
                    <div id="fileHelpId" class="form-text">only JPEG & PNG, please upload your image again</div>
                </div>
                <div class="mb-3">
                    <label for="categories_name" class="form-label">Categories</label>
                    <select class="form-control" name="categories_name">
                        <option value="Technology">Technology</option>
                        <option value="Business">Business</option>
                        <option value="Science">Science</option>
                        <option value="Health">Health</option>
                        <option value="Sports">Sports</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="History">History</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
