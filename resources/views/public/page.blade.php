@extends('layouts.web_public')
@section('content')
    <div class="breadcrumb__container">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="bi bi-house-door-fill"></i>
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item " aria-current="page">
                        <a href="{{ route('page', $page->slug) }}">
                            {{ $page->title }}
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page__container pt-3">
        <div class="container">
            <h3>{{ $page->title }}</h3>
            <div class="page__content">
                {!! $page->content !!}
            </div>
        </div>

    </div>
@endsection
