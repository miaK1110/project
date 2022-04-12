@extends('Layouts.app')

@section('title', 'サーバーエラー')

@section('content')
    @php
    $url = url()->previous();
    @endphp
    @endphp
    <error-page-component :url='@json($url)'></error-page-component>
@endsection
