<!-- Responsive Datatable -->
<div>
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">{{ __('Plan Manage') }} /</span> {{ __('Daily Plan') }}
    </h4>
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">{{ __('List of daily plan') }}</h5>
            @can('create-plan')
                <button class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light" style="margin-right:24px"
                    type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add">
                    <span>
                        <i class="ti ti-plus ti-xs me-0 me-sm-2"></i>
                        <span class="d-none d-sm-inline-block">{{ __('Add New') }}</span>
                    </span>
                </button>
            @endcan
        </div>
        <div class="col-md-2 ml-auto mr-3" style="margin-left:auto;margin-right:25px">
            <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                    placeholder="{{ __('Search...') }}" aria-label="Search..." aria-describedby="basic-addon-search31"
                    fdprocessedid="pjzbzc">
            </div>
        </div>

        <div class="table-responsive text-nowrap p-3 mb-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>{{ __('Name Plan') }}</th>
                        <th>{{ __('Name Title') }}</th>
                        <th>{{ __('Profit') }}(%)</th>
                        <th>{{ __('Start Date') }}</th>
                        <th>{{ __('End Date') }}</th>
                        <th>{{ __('Closing Date') }}</th>
                        <th>{{ __('Min Deposit') }}</th>
                        <th>{{ _('Max Deposit') }}</th>
                        <th style="width:80px">{{ __('Action') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($list_plans) > 0)
                        @foreach ($list_plans as $key => $plan)
                            <tr class="odd">
                                <td>{{ ++$key }}</td>
                                <td>{{ $plan->name }}</td>
                                <td>{{ $plan->title }}</td>
                                <td>{{ $plan->discount }}%</td>
                                <td>{{ \Carbon\Carbon::parse($plan->from_date)->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($plan->to_date)->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($plan->end_date)->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}
                                </td>
                                <td>{{ $plan->min_deposit }}$</td>
                                <td>{{ $plan->max_deposit }}$</td>
                                <td>
                                    <div class="dropdown" wire:ignore>
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                        <div class="dropdown-menu">
                                            @can('update-plan')
                                                <button data-kt-action="update" data-id={{ $plan->id }}
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update"
                                                    class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-pencil me-1"></i>
                                                    {{ __('Update') }}</button>
                                            @endcan
                                            @can('delete-plan')
                                                <button wire:click="delete({{ $plan->id }})" class="dropdown-item"
                                                    href="javascript:void(0);"><i class="ti ti-trash me-1"></i>
                                                    {{ __('Delete') }}</button>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12" style="text-align:center; color:red">
                                {{ __('No data') }}
                            </td>
                        </tr>
                    @endif
            </table>
            <div class="mt-3">
                {{ $list_plans->links() }}
            </div>
        </div>
    </div>
</div>
