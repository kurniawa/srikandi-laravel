@extends('layouts.main', $cart)
@section('content')
    <main>
        <x-errors-any></x-errors-any>
        <x-validation-feedback></x-validation-feedback>
        test
        <x-back-button :back=$back :backRoute=$backRoute :backRouteParams=$backRouteParams></x-back-button>
    </main>
@endsection
