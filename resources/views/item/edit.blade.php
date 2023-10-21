@extends('adminlte::page')

@section('title', '店舗編集')

@section('content_header')
    <div class="detail-header clearfix">
        <div class="float-left">
            <h1>お店の編集</h1>
        </div>
        <div class="float-right">
            <form method="post" action="{{ route('detail.destroy', ['id'=>$item->id]) }}">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-outline-danger" onclick='return confirm("本当に削除しますか？")'>削除する</button>
            </form>
        </div>
    </div>
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
                <form method="POST" action="{{ route('detail.update', ['id'=>$item->id]) }}" enctype='multipart/form-data'>
                @csrf
                @method('patch')
                    <div class="form-group">
                        <label for="exampleFormControlInput1">店名<span class="font-weight-light"> *必須</span></label>
                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="お店の名前を入力" value="{{ old(('name'), $item->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">カテゴリ<span class="font-weight-light"> *選択必須</span></label>
                        <select class="form-control" name="category" id="exampleFormControlSelect1">
                        @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if($category->id == $item->category_id) selected @endif>
                                {{ $category->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlInput1">住所</label>
                        <input type="text" name="address" class="form-control" id="exampleFormControlInput1" placeholder="住所を入力" value="{{ old(('address'), $item->address) }}">                    
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlInput1">電話番号</label>
                        <input type="text" name="tel" class="form-control" id="exampleFormControlInput1" placeholder="TELを入力" value="{{ old(('tel'), $item->tel) }}">                    
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlInput1">外部リンク</label>
                        <input type="text" name="ex_link" class="form-control" id="exampleFormControlInput1" placeholder="例）食べログURLなど" value="{{ old(('ex_link'), $item->ex_link) }}">                    
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">フリーメモ</label>
                        <textarea class="form-control" name="memo" id="exampleFormControlTextarea1" rows="3">{{ old(('memo'), $item->memo) }}</textarea>
                    </div>

                    @isset ($item->image)
                    <div class="current-image">
                        <img src="{{ $item->image }}" class="thumbnail" style="width: 10rem;">
                        <p>現在の画像</p>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">画像を変更</label>
                        <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    @else
                    <div class="form-group">
                        <label for="exampleFormControlFile1">画像の登録</label>
                        <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    @endisset

                    <div class="submit-button text-center">
                        <button type="submit" class="btn btn-primary" onclick='return confirm("更新しますか？")'>更新する</button>
                    </div>
                </form>
            </div>
            <div class="cancel-button text-center my-3">
                <a href="{{ route('detail', ['id'=>$item->id]) }}"><button type="button" class="btn btn-outline-primary">キャンセル</button></a>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
