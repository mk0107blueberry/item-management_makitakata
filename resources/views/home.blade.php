@extends('adminlte::page')

@section('title', 'MOGUTION')

@section('content_header')
    <h1>ピン留め中の飲食店🍽</h1>
@stop

@section('content')
    @if (count($items) > 0)
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                    @foreach ($items as $item)
                    <div class="col">
                        <div class="card shadow-sm">
                            <a href="{{ route('detail',['id'=>$item->id]) }}">
                                @isset ($item->image)
                                <img src="{{ $item->image }}" class="bd-placeholder-img card-img-top" alt="..." height="180">
                                @else
                                <!-- <img src="{{ config('default_image.default_image') }}" class="card-img-top" alt="..."> -->
                                <img src="{{ config('default_image.default_image') }}" class="bd-placeholder-img card-img-top" alt="..." height="180">
                                @endisset
                            </a>
                            <div class="card-body text-center text-wrap">
                                <h1 class="card-title fw-bold fs-5">{{ $item->name }}</h1>
                                <h2 class="card-title">{{ $item->category->name }}</h2>
                                <p class="card-title">{{ $item->genre }}</p>
                                <p class="card-title">{{ $item->released_year }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="no-result text-center">
            <h4>一致する検索結果はありませんでした</h4>
        </div>
    @endif
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
