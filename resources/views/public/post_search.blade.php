@extends('layouts.web_post')
@section('content')
    <div class="post__front_page">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="post-inner">
                        <a href="{{ route('post.detail', $hot_posts[0]->slug) }}">
                            <img src="{{ asset($hot_posts[0]->img) }}" alt="">
                            <div class="post__detail">
                                <h3>{{ $hot_posts[0]->title }}</h3>
                                <p>{{ $hot_posts[0]->user->name }}</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="post-inner post-small">
                        <a href="{{ route('post.detail', $hot_posts[1]->slug) }}">
                            <img src="{{ asset($hot_posts[1]->img) }}" alt="">
                            <div class="post__detail">
                                <h3>{{ $hot_posts[1]->title }}</h3>
                                <p>{{ $hot_posts[1]->user->name }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="post-inner post-small">
                        <a href="{{ route('post.detail', $hot_posts[2]->slug) }}">
                            <img src="{{ asset($hot_posts[2]->img) }}" alt="">
                            <div class="post__detail">
                                <h3>{{ $hot_posts[2]->title }}</h3>
                                <p>{{ $hot_posts[2]->user->name }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="post__container">
        <div class="container">
            <div class="post_category__title">
                <h3>Tìm kiếm: Kết quả tìm kiếm của từ khóa "{{ request()->input('s') }}"</h3>
            </div>
            <div class="post__list">
                @foreach ($posts as $post)
                    <div class="post__item-horizontal">
                        <a href="{{ route('post.detail', $post->slug) }}" class="post__img">
                            <img src="{{ asset($post->img) }}" alt="" title=" {{ $post->title }}">
                        </a>
                        <div class="post__body">
                            <div class="post__info">
                                <span class="post__author">{{ $post->user->name }}</span>
                                {{-- <span>-</span>
                                <span class="post__time">Tháng Sáu 30, 2023</span> --}}
                            </div>
                            <a href="{{ route('post.detail', $post->slug) }}" class="post__name"
                                title=" {{ $post->title }}">
                                {{ $post->title }}
                            </a>
                            <div class="post__desc">
                                {!! $post->desc !!}
                            </div>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
    </div>
@endsection
