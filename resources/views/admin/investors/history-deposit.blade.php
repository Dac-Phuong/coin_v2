@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.investors.history-deposit :id="$id" />
    </div>
@endsection
