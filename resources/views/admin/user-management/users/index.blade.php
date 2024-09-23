@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.users.list-user></livewire:admin.users.list-user>

        <!-- BEGIN modal -->
        <livewire:admin.users.create-user></livewire:admin.users.create-user>
        <livewire:admin.users.update-user></livewire:admin.users.update-user>
        <!--  END modal -->
    </div>
@endsection
