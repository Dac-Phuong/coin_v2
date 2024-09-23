@extends('admin.layouts.master')
@section('main')
    <div class="container-xxl flex-grow-1 container-p-y p-0">
        <livewire:admin.plans.plan-fixed.list-plan></livewire:admin.plans.plan-fixed.list-plan>
        <!-- BEGIN modal -->
        <livewire:admin.plans.plan-fixed.create-plan></livewire:admin.plans.plan-fixed.create-plan>
        <livewire:admin.plans.plan-fixed.update-plan></livewire:admin.plans.plan-fixed.update-plan>
        <!--  END modal -->
    </div>
@endsection
