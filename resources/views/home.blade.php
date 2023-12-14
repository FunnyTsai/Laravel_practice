
@extends('layouts.member')

@section('sidebar')
    @include('layouts.sidebar', ['login_user' => 'TEST'])
@endsection
