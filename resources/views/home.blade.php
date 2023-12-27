
@extends('layouts.page', ['webTitle' => '首頁'])

@section('sidebar')
    @include('layouts.sidebar', ['login_user' => 'TEST'])
@endsection
