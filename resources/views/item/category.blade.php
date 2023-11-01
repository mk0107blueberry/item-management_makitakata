@extends('adminlte::page')

@section('title', '飲食店一覧')
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

@section('content_header')
    <div class="list-header d-flex justify-content-between">
        @if ($category_id == 1)
        <h1>🍺居酒屋・バー</h1>
        @elseif ($category_id == 2)
        <h1>🍣和食</h1>
        @elseif ($category_id == 3)
        <h1>🍽洋食・西洋料理</h1>
        @elseif ($category_id == 4)
        <h1>🐲中華料理</h1>
        @elseif ($category_id == 5)
        <h1>🦐アジア・エスニック</h1>
        @elseif ($category_id == 6)
        <h1>🍛カレー</h1>
        @elseif ($category_id == 7)
        <h1>🥩焼肉・ホルモン</h1>
        @elseif ($category_id == 8)
        <h1>🍜ラーメン・つけ麺</h1>
        @elseif ($category_id == 9)
        <h1>☕カフェ・喫茶店</h1>
        @elseif ($category_id == 10)
        <h1>🍰スイーツ</h1>
        @elseif ($category_id == 11)
        <h1>🥐パン</h1>
        @elseif ($category_id == 12)
        <h1>🍲その他</h1>
        @endif
        <form class="d-flex" role="search" action="{{ route('category', [$category_id,]) }}" method="GET">
            @csrf
            <input class="form-control me-2 mx-1" type="search" name="keyword" placeholder="店名/住所/TEL" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
    </div>
@stop

@section('content')
    @if(session('message'))
    <div class="alert alert-primary">{{session('message')}}</div>
    @elseif(session('delete-message'))
    <div class="alert alert-danger">{{session('delete-message')}}</div>
    @endif

    @if (count($items) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">飲食店一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">お店の新規登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>📌ピン留め</th>
                                <th>カテゴリ</th>
                                <th>店名</th>
                                <th>住所</th>
                                <th>TEL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>        
                                    <form class="pinAction">
                                    @csrf
                                        <td>
                                            <label class="form-check text-center">
                                                @if ($item->pin === null)
                                                <input class="form-check-input position-static pin-toggle" type="checkbox" data-item-id="{{ $item->id }}">
                                                @elseif ($item->pin === "pinned")
                                                <input class="form-check-input position-static pin-toggle" type="checkbox" data-item-id="{{ $item->id }}" checked="checked">
                                                @endif
                                            </label>
                                        </td>
                                    </form>
                                    <td>{{ $item->category->name }}</td>
                                    <td><a href="{{ route('detail', ['id'=>$item->id]) }}">{{ $item->name }}</a></td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->tel }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">飲食店一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">お店の新規登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>📌ピン留め</th>
                                <th>カテゴリ</th>
                                <th>店名</th>
                                <th>住所</th>
                                <th>TEL</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="no-result text-center">
        <h4>一致する検索結果はありませんでした</h4>
    </div>
    @endif

    <div class="main-pagination">
        {!! $items->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
    $('.pin-toggle').click(function() {
        const itemId = $(this).data('item-id');
        console.log(itemId);

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: '{{ route('index.pin') }}', // 適切なルートを設定
            type: 'POST',
            data: {
                itemId: itemId,
            },
            success: function(data) {
                console.log('成功です。');
            },
            error: function(error) {
                alert('ファイルの取得に失敗しました。');
            }
        });
    });
    </script>
@stop
