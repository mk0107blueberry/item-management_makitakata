@extends('adminlte::page')

@section('title', 'MOGUTION')
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

@section('content_header')
    <div class="header d-flex justify-content-between">
    @if (count($items) > 0)
    <h1>📌ピン留めアイテム</h1>
    <button id="toggleAll" class="btn btn-outline-dark">📌一括操作</button>
    @else
    <h1>📌ピン留めアイテム</h1>
    @endif
    </div>
@stop

@section('content')
    @if (count($items) > 0)
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                    @foreach ($items as $item)
                    <div class="col">
                        <div class="card shadow-sm" style="background-color: #d4dcda;">

                            <form class="pinAction">
                            @csrf
                            <label class="form-check px-4">
                                @if ($item->pin === null)
                                <input class="form-check-input position-static pin-toggle" type="checkbox" data-item-id="{{ $item->id }}">
                                @elseif ($item->pin === "pinned")
                                <input class="form-check-input position-static pin-toggle" type="checkbox" data-item-id="{{ $item->id }}" checked="checked">
                                @endif
                                📌
                            </label>
                            </form>

                            <a href="{{ route('detail',['id'=>$item->id]) }}">
                                @isset ($item->image)
                                <img src="{{ $item->image }}" class="bd-placeholder-img card-img-top" alt="..." height="180">
                                @else
                                <img src="{{ config('default_image.default_image') }}" class="bd-placeholder-img card-img-top" alt="..." height="180">
                                @endisset
                            </a>
                            <span class="badge badge-light my-2 mx-2" style="width: 50%">{{ $item->category->name }}</span>
                            <div class="card-body text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center;">
                                <p class="card-text" style="flex: 1; overflow: hidden; text-overflow: ellipsis; font-size: 1em; white-space: nowrap;">
                                {{ $item->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="no-result text-center">
            <h4>ピン留めアイテムはありません</h4>
        </div>
    @endif
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
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
            url: '{{ route('home.pin') }}', // 適切なルートを設定
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


    // 一括チェックボタンのクリックイベントを処理
    $('#toggleAll').click(function() {
        // トグルスイッチの状態を取得
        const toggleState = $(this).data('toggleState');

        // 変更されたチェックボックスの情報を収集する配列
        let changedCheckboxes = [];

        // 全てのチェックボックスに対して状態を設定
        $('.pin-toggle').each(function() {
            // トグルスイッチの状態に合わせてチェックボックスの状態を切り替え
            if (toggleState === 'on') {
                $(this).prop('checked', true); // 一括でオン
            } else {
                $(this).prop('checked', false); // 一括でオフ
            }

            // 変更されたチェックボックスの情報を収集
            var itemId = $(this).data('item-id');
            changedCheckboxes.push(itemId);
        });

        // トグルスイッチの状態を切り替え
        $(this).data('toggleState', toggleState === 'on' ? 'off' : 'on');

        // 一括でAjaxリクエストを送信
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: '{{ route('home.pins') }}', // 適切なルートを設定
            type: 'PUT',
            data: {
                itemIds: changedCheckboxes, // 変更されたチェックボックスのIDリスト
            },
            success: function(data) {
                console.log('成功です。');
                console.log(changedCheckboxes);
            },
            error: function(error) {
                alert('ファイルの取得に失敗しました。');
            }
        });
    });
    </script>
@stop
