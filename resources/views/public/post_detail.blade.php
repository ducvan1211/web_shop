@extends('layouts.web_post')
@section('content')
    <div class="post__img-full-width container">
        <div>
            <img src="{{ asset($post->img) }}" alt="">
        </div>
    </div>
    <div class="post__detail-content container">
        <div class="row">
            <div class="col-8">
                <h3 class="post__title">{{ $post->title }}</h3>
                <div class="post__info">
                    <span class="post__author">{{ $post->user->name }}</span>
                    {{-- <span class="post__author">
                        <i class="bi bi-calendar"></i>
                        Tháng Sáu 30, 2023</span> --}}
                </div>
                <div class="post__content">
                    {!! $post->content !!}
                </div>
            </div>
            <div class="col-4">
                <div class="sidebar">
                    <div class="cat__title">
                        <h3>Tin mới nhất</h3>
                    </div>
                    @foreach ($new_posts as $post)
                        <div class="post-inner post-small">
                            <a href="{{ route('post.detail', $post->slug) }}">
                                <img src="{{ asset($post->img) }}" alt="{{ $post->title }}">
                                <div class="post__detail">
                                    <h3>{{ $post->title }}</h3>
                                    <p>{{ $post->user->name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
@endsection
