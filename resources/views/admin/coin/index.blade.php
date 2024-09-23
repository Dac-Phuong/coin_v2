@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.coin.list-coin></livewire:admin.coin.list-coin>
        <livewire:admin.coin.create-coin-profit></livewire:admin.coin.create-coin-profit>
        <livewire:admin.coin.create-coin></livewire:admin.coin.create-coin>
        <livewire:admin.coin.update-coin></livewire:admin.coin.update-coin>
    </div>
@endsection
