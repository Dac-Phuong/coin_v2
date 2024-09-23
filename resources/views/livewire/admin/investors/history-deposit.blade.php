  @php
    function formatNumber($number, $decimals = 6)
    {
        $formattedNumber = number_format($number, $decimals);
        return rtrim(rtrim($formattedNumber, '0'), '.');
    }
@endphp
  <div>
        <h4 class="py-3 mb-2">
            <span class="text-muted fw-light">{{ __('Investor Manager') }} /</span> {{ __('Investor List') }} /</span>
            {{ __('Deposit History') }}
        </h4>
        <div class="card">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-header">{{ __('Investor List') }}</h5>
                <a href="{{ url('admin/list-investor') }}"
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
                        placeholder="{{ __('Search...') }}" aria-label="Search..."
                        aria-describedby="basic-addon-search31" fdprocessedid="pjzbzc">
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3 mb-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">{{ __('Name plan') }}</th>
                            <th scope="col">{{ __('Number of days') }}</th>
                            <th scope="col">{{ __('Profit') }}</th>
                            <th scope="col">{{ __('Deposits Amount') }}</th>
                            <th scope="col">{{ __('Amount Received') }}</th>
                            <th scope="col">{{ __('Send date') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($history_deposit) && count($history_deposit) > 0)
                            @foreach ($history_deposit as $key => $deposit)
                                <tr>
                                    <td scope="row">{{ ++$key }}</td>
                                    <td>{{ $deposit->name }}</td>
                                    <td>{{ $deposit->number_days }}</td>
                                    <td>{{ $deposit->plan_discount }}%</td>
                                    <td>{{ formatNumber($deposit->amount) }} {{$deposit->name_coin}}</td>
                                    <td>{{ formatNumber($deposit->total_amount) }} {{$deposit->name_coin}}</td>
                                    <td>{{ $deposit->start_date ?? $deposit->from_date }}
                                    </td>
                                    @if ($deposit->investor_with_plants_status == 0)
                                        <td class="text-primary">
                                            Pending
                                        </td>
                                    @elseif($deposit->investor_with_plants_status == 1)
                                        <td class="text-warning">
                                            Running
                                        </td>
                                    @elseif($deposit->investor_with_plants_status == 2)
                                        <td class="text-success">
                                            Success
                                        </td>
                                    @else
                                        <td class="text-danger">
                                            Cancel
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12" style="text-align:center; color:red">
                                    {{ _('No data') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $history_deposit->links() }}
                </div>
            </div>

        </div>
    </div>
