<div>
    <!-- Responsive Datatable -->
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">{{ __('Wallet Manage') }} /</span> {{ __('Wallet List') }} </span>
    </h4>
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">{{ __('Wallet List') }}</h5>
            <a href="{{ url('admin/list-network') }}"
                class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light" style="margin-right:24px">
                <span>
                    <i class="ti ti-arrow-left"></i>
                    <span class="d-none d-sm-inline-block">{{ __('Go back') }}</span>
                </span>
            </a>
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>{{ __('Network Name') }}</th>
                        <th>{{ __('Plan Name') }}</th>
                        <th>{{ __('Wallet Address') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Created Date') }}</th>
                        <th style="width:80px">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($list_wallet) > 0)
                        @foreach ($list_wallet as $key => $wallets)
                            <tr class="odd">
                                <td>{{ ++$key }}</td>
                                <td>{{ $wallets->network_name }}</td>
                                <td>{{ $wallets->plan_name }}</td>
                                <td>{{ $wallets->wallet_address }}</td>
                                @if ($wallets->status == 0)
                                    <td class="text-primary">
                                        {{ __('Inactive') }}
                                    </td>
                                @else
                                    <td class="text-success">
                                        {{ __('Active') }}
                                    </td>
                                @endif
                                <td>{{ $wallets->created_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" wire:click="toggle({{ $wallets->id }})"
                                            class="btn p-0 "><i class="ti ti-dots-vertical"></i></button>
                                        @if ($wallets->id == $wallet_id && $toggleState)
                                            <div class="dropdown-menu show" style="right: 90px">
                                                @can('update-wallets')
                                                    <button data-kt-action="update" data-id={{ $wallets->id }}
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_update"
                                                        wire:click="closeToggle" class="dropdown-item"
                                                        href="javascript:void(0);"><i class="ti ti-pencil me-1"></i>
                                                        {{ __('Update') }}</button>
                                                @endcan

                                                @can('delete-wallets')
                                                    <button wire:click="delete({{ $wallets->id }})" class="dropdown-item"
                                                        href="javascript:void(0);"><i class="ti ti-trash me-1"></i>
                                                        {{ __('Delete') }}</button>
                                                @endcan
                                            </div>
                                        @endif
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
                {{ $list_wallet->links() }}
            </div>
        </div>
    </div>

</div>
