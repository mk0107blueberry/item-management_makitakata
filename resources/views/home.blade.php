@extends('adminlte::page')

@section('title', 'MOGUTION')
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

@section('content_header')
    <h1>📌ピン留めアイテム</h1>
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
                                <!-- <p class="card-title fw-bold fs-5">【{{ $item->category->name }}】</p> -->
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
    <!-- <script> console.log('Hi!'); </script> -->
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
