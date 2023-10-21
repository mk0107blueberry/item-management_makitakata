@extends('adminlte::page')

@section('title', '飲食店一覧')

@section('content_header')
    <h1>飲食店一覧</h1>
@stop

@section('content')
    @if(session('message'))
    <div class="alert alert-primary">{{session('message')}}</div>
    @elseif(session('delete-message'))
    <div class="alert alert-danger">{{session('delete-message')}}</div>
    @endif
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
                                <th>ピン留め</th>
                                <th>カテゴリ</th>
                                <th>店名</th>
                                <th>住所</th>
                                <th>TEL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>        
                                    <td>{{ $item->pin }}</td>
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
@stop

@section('css')
@stop

@section('js')
@stop
