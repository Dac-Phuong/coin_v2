@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.withdraw.list-withdraw />
        <livewire:admin.withdraw.create-withdrawal-fees />
        <livewire:admin.withdraw.detail-withdraw />
    </div>
@endsection
