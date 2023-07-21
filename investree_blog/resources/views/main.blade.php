@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Articles</h1>
        <div class="row">
          @foreach ($articles as $article)
          <div class="col-sm-6 mb-2">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">{{ $article->title }}</h5>
                      <p class="card-subtitle">{{$article->category->name}}</p>
                      <p class="card-subtitle">By {{$article->user->name}}</p>
                      <p class="card-text text-truncate">{{ $article->content }}</p>
                      <a href="{{route('article.show',['id' => $article->id])}}" class="btn btn-primary">Full article</a>
                  </div>
              </div>
          </div>
      @endforeach
      {{$articles->links('pagination::bootstrap-4')}}  
            </div>
      </div>
    @endsection
