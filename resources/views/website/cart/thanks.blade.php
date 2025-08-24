@extends('website.layouts.master')

@section('title',':: Thanks | '.settings('company_name').' ::')

@section('content')
    @include('website.shopping-partials.orderbox')
@endsection
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush
