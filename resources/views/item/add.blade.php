@extends('adminlte::page')

@section('title', '新規登録')
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

@section('content_header')
    <h1>お店の新規登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif

            <div class="register">
                <form method="POST" enctype='multipart/form-data'>
                @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">店名<span class="font-weight-light"> *必須</span></label>
                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="お店の名前を入力" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">カテゴリ<span class="font-weight-light"> *選択必須</span></label>
                        <select class="form-control" name="category" id="exampleFormControlSelect1">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlInput1">住所</label>
                        <input type="text" name="address" class="form-control" id="exampleFormControlInput1" placeholder="住所を入力" value="{{ old('address') }}">                    
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlInput1">電話番号</label>
                        <input type="text" name="tel" class="form-control" id="exampleFormControlInput1" placeholder="TELを入力"  value="{{ old('tel') }}">                    
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlInput1">外部リンク</label>
                        <input type="text" name="ex_link" class="form-control" id="exampleFormControlInput1" placeholder="例）食べログURLなど" value="{{ old('ex_link') }}">                    
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">フリーメモ</label>
                        <textarea class="form-control" name="memo" id="exampleFormControlTextarea1" rows="3">{{ old('memo') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="file">画像をアップロード</label>
	                    <div id="file" class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileInput" accept="image/*" name="image">
                                <label class="custom-file-label" for="fileInput" data-browse="参照">画像ファイルを選択...</label>
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary reset">取消</button>
                            </div>
	                    </div>

                        <div id="preview" class="mt-2">
                            <!-- プレビュー画像表示 -->
                        </div>
                    </div>
                    
                    <div class="submit-button text-center">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .custom-file {
        max-width: 30rem;
        overflow: hidden;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // ファイル選択時の処理
            $('#fileInput').on('change', handleFileSelect);

            function handleFileSelect(evt) {
                const file = evt.target.files[0];

                if (file && file.type.match('image.*')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const $html = [
                            '<div>',
                            '<img class="img-thumbnail" src="', e.target.result, '" title="', escape(file.name), '" style="max-height: 200px;" />',
                            '</div>'
                        ].join('');
                        
                        $('#preview').html($html);
                    };

                    reader.readAsDataURL(file);
                }
            }

            // ファイルの取消
            $('.reset').click(function() {
                $('#fileInput').val(''); // ファイル選択をクリア
                $('#preview').html(''); // プレビューをクリア
            });
        });
    </script>
@stop
