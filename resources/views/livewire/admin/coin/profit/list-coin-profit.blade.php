<div wire:poll.20s>
    <!-- Responsive Datatable -->
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">{{ __('Coin Manage') }} /</span> {{ __('Profit List') }}
    </h4>
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">{{ __('Profit List') }}</h5>
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
                        <th>{{ __('Coin Name') }}</th>
                        <th>{{ __('Coin Image') }}</th>
                        <th>{{ __('Network Group') }}</th>
                        <th>{{ __('Coin Price') }}</th>
                        <th>{{ __('Rate Coin') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th style="width:80px">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($list_coin) && count($list_coin) > 0)
                        @foreach ($list_coin as $key => $coin)
                            <tr class="odd">
                                <td>{{ ++$key }}</td>
                                <td>{{ $coin->coin_name }}</td>
                                <td><img width="50px" src="{{ $coin->coin_image }}" alt="Uploaded Image"
                                        style="height: 50px"></td>
                                <td>
                                    @if (isset($coin->network_name))
                                        @foreach ($coin->network_name as $network_name)
                                            <span>
                                                {{ $network_name }},
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="">
                                    ${{ number_format($coin->coin_price, $coin->coin_decimal) }}
                                </td>
                                @if ($coin->rate_coin == 0)
                                    <td class="text-danger">
                                        {{ __('Manual') }}
                                    </td>
                                @else
                                    <td class="text-primary">
                                        {{ __('Auto') }}
                                    </td>
                                @endif
                                @if ($coin->status == 0)
                                    <td class="text-primary">
                                        {{ __('Active') }}
                                    </td>
                                @else
                                    <td class="text-success">
                                        {{ __('Inactive') }}
                                    </td>
                                @endif
                                <td>{{ $coin->description }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            wire:click="toggle({{ $coin->id }})" data-bs-toggle="dropdown"><i
                                                class="ti ti-dots-vertical"></i></button>
                                        @if ($coin->id == $id && $toggleState)
                                            <div class="dropdown-menu show" style="right: 90px">
                                                @can('update-coin')
                                                    <button class="dropdown-item" style="margin-right:24px" type="button"
                                                        wire:click="closeToggle" data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_add_profit">
                                                        <span>
                                                            <i class="ti ti-plus ti-xs me-0 me-sm-2"></i>
                                                            <span
                                                                class="d-none d-sm-inline-block">{{ __('Add Profit') }}</span>
                                                        </span>
                                                    </button>
                                                    <a class="dropdown-item" href="">
                                                        <span>
                                                            <i class="ti ti-eye ti-xs me-0 me-sm-2"></i>
                                                            <span
                                                                class="d-none d-sm-inline-block">{{ __('View Profit') }}</span>
                                                        </span>
                                                    </a>
                                                    <button data-kt-action="update" data-id={{ $coin->id }}
                                                        wire:click="closeToggle" data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_update" class="dropdown-item"
                                                        href="javascript:void(0);"><i class="ti ti-pencil me-1"></i>
                                                        {{ __('Update') }}</button>
                                                @endcan
                                                @can('delete-coin')
                                                    <button wire:click="delete({{ $coin->id }})" class="dropdown-item"
                                                        wire:click="closeToggle" href="javascript:void(0);"><i
                                                            class="ti ti-trash me-1"></i>
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
                {{-- {{ $list_coin->links() }} --}}
            </div>
        </div>
    </div>

</div>
