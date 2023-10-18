@extends('adminlte::page')

@section('title', '新規登録')

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
                <form method="POST">
                @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">店名<span class="font-weight-light"> *必須</span></label>
                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="お店の名前を入力">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">カテゴリ<span class="font-weight-light"> *選択必須</span></label>
                        <select class="form-control" name="category" id="exampleFormControlSelect1">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlInput1">住所</label>
                        <input type="text" name="address" class="form-control" id="exampleFormControlInput1" placeholder="住所を入力">                    
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlInput1">電話番号</label>
                        <input type="text" name="tel" class="form-control" id="exampleFormControlInput1" placeholder="TELを入力">                    
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlInput1">外部リンク</label>
                        <input type="text" name="ex_link" class="form-control" id="exampleFormControlInput1" placeholder="例）食べログURLなど">                    
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">フリーメモ</label>
                        <textarea class="form-control" name="memo" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">お店の画像を登録する</label>
                        <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
