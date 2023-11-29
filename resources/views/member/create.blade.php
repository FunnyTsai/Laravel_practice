@extends('layouts.member')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('main')
    <h1>帳號 > 新增帳號</h1>

    <form action="{{ route('member.store') }}" method="post">
        @csrf
        <div class='field my-1'>
            <label for="">帳號</label>
            <input type="text" name="USER_ID" class="border border-gray-300">
        </div>

        <div class='field my-2'>
            <label for="">密碼</label>
            <input type="text" name="USER_PASSWORD" class="border border-gray-300">
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">新增帳號</button>
        </div>
    </form>
@endsection