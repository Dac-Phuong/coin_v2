@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.wallets.list-wallet :id="$id" />
        <livewire:admin.wallets.create-wallet></livewire:admin.wallets.create-wallet>
        <livewire:admin.wallets.update-wallet></livewire:admin.wallets.update-wallet>
    </div>
@endsection
