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
                        <div class="card shadow-sm">

                            <form class="pinAction">
                            @csrf
                            <label class="form-check px-4">
                                @if ($item->pin === null)
                                <input class="form-check-input position-static pin-toggle" type="checkbox" data-item-id="{{ $item->id }}">
                                @elseif ($item->pin === "pinned")
                                <input class="form-check-input position-static pin-toggle" type="checkbox" data-item-id="{{ $item->id }}" checked="checked">
                                @endif
                            </label>
                            </form>

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
