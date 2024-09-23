    <!-- Responsive Datatable -->
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
            {{ __('Withdarw History') }}
        </h4>
        <div class="card">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-header">{{ __('Withdarw History') }}</h5>
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
                            <th scope="col">{{ __('Amount Withdraw') }}</th>
                            <th scope="col">{{ __('Withdrawal Date') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($history_withdraw) && count($history_withdraw) > 0)
                            @foreach ($history_withdraw as $key => $withdraw)
                                <tr>
                                    <td scope="row">
                                        {{ ++$key }}</td>
                                    <td>{{ formatNumber($withdraw->amount) }} {{$withdraw->coin_name}}
                                    </td>
                                    <td>{{ $withdraw->created_at }}</td>
                                    <td
                                        class="{{ $withdraw->status == 0 ? 'text-primary' : ($withdraw->status == 1 ? 'text-success' : ($withdraw->status == 2 ? 'text-danger' : 'text-danger')) }}">
                                        {{ $withdraw->status == 0 ? 'Pending' : ($withdraw->status == 1 ? 'Success' : ($withdraw->status == 2 ? 'Cancel' : 'Cancel')) }}
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12" style="text-align:center; color:red">
                                    {{ __('No data') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $history_withdraw->links() }}
                </div>
            </div>

        </div>
    </div>
