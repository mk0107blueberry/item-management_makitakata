@extends('adminlte::page')

@section('title', '店舗詳細')

@section('content_header')
    <div class="detail-header clearfix">
        <div class="float-left mx-4 my-2">
            <h1>{{ $item->name }}</h1>
            <button type="button" class="btn btn-info" disabled>{{ $item->category->name }}</button>
        </div>
        <div class="float-right">
        <a href="{{ route('detail.edit', ['id'=>$item->id]) }}"><button type="button" class="btn btn-outline-secondary">編集</button></a>
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
                        <img src="{{ config('default_image.default_image') }}" class="card-img-top" alt="...">
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

        <!-- nullのときは「ピン留めする」ボタン、pinnedのときは「ピン留めを外す」ボタンに表示を変えたい -->
        <form class="pinAction">
            @csrf
            @isset($item->pin)
            <div class="text-center">
            <button type="button" id="pinButton" class="btn btn-primary">ピン留めをはずす</button>
            </div>
            @else
            <div class="text-center">
            <button type="button" id="pinButton" class="btn btn-outline-primary">ピン留めする</button>
            </div>
            @endisset
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
    $(function() {
        $('#pinButton').click(function() {  //id="pinButton"をクリックした時に発動
            $.ajax({
                headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },

                url     :   '{{ route('detail.pin', ['id'=>$item->id]) }}',  //formのaction要素を参照
                type    :   'post',  //formのmethod要素を参照
                // data    :   form.serialize(),     //formで送信している内容を送る
            })

            //通信が成功した時
            .done((data)=>{
                //何か処理
                console.log('成功です');
                console.log(data);
                console.log(data.status);
                console.log($(this));
                if(data.status === null) {
                    console.log('nullです');
                    $(this).text('ピン留めする');
                    $(this).removeClass('btn-primary');
                    $(this).addClass('btn btn-outline-primary');
                } else if(data.status === 'pinned') {
                    console.log('pinnedです');
                    $(this).text('ピン留めをはずす');
                    $(this).removeClass('btn-outline-primary');
                    $(this).addClass('btn btn-primary');
                }
            })
            //通信が失敗したとき
            .fail((error)=>{
                //何か処理
                console.log('失敗です');
                alert('ファイルの取得に失敗しました。');
            })
        })
    });
    </script>
@stop
