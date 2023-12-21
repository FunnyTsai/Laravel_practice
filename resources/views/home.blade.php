
@extends('layouts.page')

@section('sidebar')
    @include('layouts.sidebar', ['login_user' => 'TEST'])
@endsection
