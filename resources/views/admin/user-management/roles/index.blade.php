@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <!-- Responsive Datatable -->
        <livewire:admin.roles.list-role></livewire:admin.roles.list-role>
        {{-- BEGIN modal --}}
        <livewire:admin.roles.create-role></livewire:admin.roles.create-role>
        <livewire:admin.roles.update-role></livewire:admin.roles.update-role>
        {{-- END modal --}}
    </div>
@endsection
