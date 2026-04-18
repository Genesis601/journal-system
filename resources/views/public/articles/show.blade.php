@extends('layouts.public')
@section('title', $article->title)
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-semibold text-gray-800">{{ $article->title }}</h1>
    <p class="text-gray-500 mt-2">Coming soon...</p>
</div>
@endsection