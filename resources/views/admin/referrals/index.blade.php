@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.referral.list-referral></livewire:admin.referral.list-referral>
        <livewire:admin.referral.create-referral></livewire:admin.referral.create-referral>
    </div>
@endsection
