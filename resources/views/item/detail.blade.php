@extends('adminlte::page')

@section('title', '店舗詳細')

@section('content_header')
    <div class="detail-header clearfix">
        <div class="float-left mx-4 my-2">
            <h1>{{ $item->name }}</h1>
            <button type="button" class="btn btn-lg btn-primary" disabled>{{ $item->category->name }}</button>
        </div>
        <div class="float-right">
            <button type="button" class="btn btn-outline-secondary">編集</button>
        </div>
    </div>
@stop

@section('content')
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3">
                <div class="col">
                    <div class="card shadow-sm">
                        @isset ($item->image)
                        <img src="{{ $item->image }}" class="card-img-top" alt="...">
                        @else
                        <img src="https://www.templatebank.com/images/creators/preview/088_0146_L.jpg" class="card-img-top" alt="...">
                        @endisset
                    </div>
                </div>
                <div class="col">
                    <div class="album-info">
                        <div class="card-body my-3">
                            <ul>
                                <li class="font-weight-bold fs-2 list-unstyled">{{ $item->name }}</li>
                                <li class="fs-4 list-unstyled">{{ $item->address }}</li></a>
                                <li class="list-unstyled">{{ $item->tel }}</li>
                                @isset ($item->ex_link)
                                <a href="{{ $item->ex_link }}" target="_blank"><li class="list-unstyled">外部サイトへ</li></a>
                                @else
                                <li class="list-unstyled text-secondary">外部サイトの登録はありません</li>
                                @endisset
                            </ul>
                        </div>
                        <div class="card shadow-sm px-5">
                            @isset ($item->memo)
                            <p class="card-text py-5">{{ $item->memo }}</p>
                            @else
                            <p class="card-text py-5 text-secondary">メモはありません</p>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-outline-primary">ピン留めする</button>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
