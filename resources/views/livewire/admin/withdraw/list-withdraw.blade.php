<!-- Responsive Datatable -->
@php
    function formatNumber($number, $decimals = 6)
    {
        $formattedNumber = number_format($number, $decimals);
        return rtrim(rtrim($formattedNumber, '0'), '.');
    }
@endphp
<div>
    <h4 class="py-3 mb-2" wire:poll.15s>
        <span class="text-muted fw-light">{{ __('Manage withdraw') }} /</span> {{ __('Withdraw List') }}
    </h4>
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">{{ __('Withdraw List') }}</h5>
            {{-- <button class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light" style="margin-right:24px"
                type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add">
                <span>
                    <i class="ti ti-settings me-0 me-sm-1"></i>
                    <span class="d-none d-sm-inline-block">{{ __('Setting') }}</span>
                </span>
            </button> --}}
        </div>
        <div class="col-md-2 w-100 justify-content-between my-2 mr-3 flex-wrap d-flex px-4 ">
            <div class="d-flex flex-wrap m-0 wrap-form">
                <div class="d-flex align-items-center wrap-form-date">
                    <p class="m-0" style="width: 120px;font-weight: 600">{{ __('From date') }}</p>
                    <input type="date" class="form-control" value="{{ $from_date }}" wire:model.live="from_date"
                        style="max-width: 240px">
                </div>
                <div class="d-flex align-items-center wrap-to-date">
                    <p class="m-0" style="width: 160px;padding: 0 20px;font-weight: 600">{{ __('To date') }}
                    </p>
                    <input type="date" class="form-control" value="{{ $to_date }}" wire:model.live="to_date"
                        style="max-width: 240px;">
                </div>
            </div>
            <div class="input-group input-group-merge w-20 wrap-input">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                    placeholder="{{ __('Search...') }}" aria-label="Search..." aria-describedby="basic-addon-search31"
                    fdprocessedid="pjzbzc">
            </div>
        </div>
        <div class="table-responsive text-nowrap p-3 mb-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>{{ __('Withdrawer') }}</th>
                        <th>{{ __('Coin Name') }}</th>
                        <th>{{ __('Wallet type') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Total Amount') }} </th>
                        <th>{{ __('Withdrawal date') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th style="width:80px">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($list_withdraw) > 0)
                        @foreach ($list_withdraw as $key => $withdraw)
                            <tr class="odd cursor-pointer">
                                <td data-kt-action="update" data-id={{ $withdraw->id }} data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update">{{ ++$key }}</td>
                                <td data-kt-action="update" data-id={{ $withdraw->id }} data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update">{{ $withdraw->fullname }}</td>
                                <td data-kt-action="update" data-id={{ $withdraw->id }} data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update">{{ $withdraw->coin_name }}</td>
                                <td data-kt-action="update" data-id={{ $withdraw->id }} data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update">{{ $withdraw->wallet_name }}</td>
                                <td data-kt-action="update" data-id={{ $withdraw->id }} data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update">{{ formatNumber($withdraw->amount) }} {{ $withdraw->coin_name }}</td>
                                <td data-kt-action="update" data-id={{ $withdraw->id }} data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update">
                                    {{ formatNumber($withdraw->total_amount) }}
                                    {{ $withdraw->coin_name }}
                                </td>
                                <td data-kt-action="update" data-id={{ $withdraw->id }} data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update">{{ $withdraw->created_at }}</td>
                                <td data-kt-action="update" data-id={{ $withdraw->id }} data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_update"
                                    class="{{ $withdraw->status == 0 ? 'text-primary' : ($withdraw->status == 1 ? 'text-success' : ($withdraw->status == 2 ? 'text-danger' : 'text-danger')) }}">
                                    {{ $withdraw->status == 0 ? 'Pending' : ($withdraw->status == 1 ? 'Success' : ($withdraw->status == 2 ? 'Cancel' : 'Cancel')) }}
                                </td>
                                <td>
                                    @if ($withdraw->status == 0)
                                        <div class="d-flex">
                                            <button wire:click="comfirm_withdraw({{ $withdraw->id }})"
                                                class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light "
                                                type="button">
                                                {{ __('Confirm') }}
                                            </button>
                                            <button wire:click="cancel({{ $withdraw->id }})"
                                                class="dt-button add-new btn btn-danger ms-2 waves-effect waves-light"
                                                type="button">
                                                {{ __('Cancel') }}
                                            </button>
                                        </div>
                                    @elseif($withdraw->status == 1)
                                        <button wire:click="cancel({{ $withdraw->id }})"
                                            class="dt-button add-new btn btn-danger ms-2 waves-effect waves-light"
                                            type="button">
                                            {{ __('Cancel') }}
                                        </button>
                                    @else
                                        <button wire:click="success({{ $withdraw->id }})"
                                            class="dt-button add-new btn btn-success ms-2 waves-effect waves-light"
                                            type="button">
                                            {{ __('Success') }}
                                        </button>
                                    @endif
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
                {{ $list_withdraw->links() }}
            </div>
        </div>
    </div>

</div>
