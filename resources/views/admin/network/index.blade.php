@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.network.list-network></livewire:admin.network.list-network>
        <livewire:admin.network.create-network></livewire:admin.network.create-network>
        <livewire:admin.network.update-network></livewire:admin.network.update-network>
        <livewire:admin.wallets.create-wallet></livewire:admin.wallets.create-wallet>
    </div>
@endsection
