@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.plans.plan-daily.list-plan/>
        <!-- BEGIN modal -->
        <livewire:admin.plans.plan-daily.create-plan/>
        <livewire:admin.plans.plan-daily.update-plan/>
        <!--  END modal -->
    </div>
@endsection
