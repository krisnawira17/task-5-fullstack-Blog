@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{$article->title}}</h1>
        <h2>By {{$article->user->name}}</h2>
        @if(!empty($article->image))
        <div class="text-center">
            <img class="img-thumbnail " src="{{asset('images/article_image/'. $article->image)}}">
        </div>
        @endif
        <p class="mt-2">{!! nl2br(e($article->content)) !!}</p>
        
    </div>
@endsection