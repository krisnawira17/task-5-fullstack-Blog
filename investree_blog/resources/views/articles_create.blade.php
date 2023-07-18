@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Post</h1>
    <form method="post" action="{{route('articles.store')}}">
        @csrf
        <div>
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text"
                class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="">
            </div>
            <div class="mb-3">
              <label for="content" class="form-label">Content</label>
              <textarea class="form-control" name="content" id="content" rows="20" style="resize: none"></textarea>
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Image</label>
              <input type="file" class="form-control" name="image" id="image" accept="image/jpeg, image/png" aria-describedby="fileHelpId">
              <div id="fileHelpId" class="form-text">only JPEG & PNG</div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Categories</label>
                <select class="form-control" name="categories_id">
                    <option value="1">Technology</option>
                    <option value="2">Business</option>
                    <option value="3">Science</option>
                    <option value="4">Health</option>
                    <option value="5">Sports</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection