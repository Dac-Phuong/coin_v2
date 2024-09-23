@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.deposit.list-deposit></livewire:admin.deposit.list-deposit>
        <livewire:admin.deposit.detail-deposit></livewire:admin.deposit.detail-deposit>
    </div>
@endsection
