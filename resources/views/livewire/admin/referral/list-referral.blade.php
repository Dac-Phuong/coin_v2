<!-- Responsive Datatable -->
<div>
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">{{ __('Referral Manage') }} /</span> {{ __('Referral List') }}
    </h4>
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">{{ __('Referral List') }}</h5>
            {{-- <button class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light" style="margin-right:24px"
                type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add">
                <span>
                    <i class="ti ti-settings me-0 me-sm-1"></i>
                    <span class="d-none d-sm-inline-block">{{ __('Setting') }}</span>
                </span>
            </button> --}}
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
                        <th>{{ __('Referrer name') }}</th>
                        <th>{{ __('Email Address') }}</th>
                        <th>{{ __('Number of referrals') }}</th>
                        <th>{{ __('Total amount received') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($list_referral) > 0)
                        @foreach ($list_referral as $key => $withdraw)
                            <tr class="odd">
                                <td>{{ ++$key }}</td>
                                <td>{{ $withdraw->fullname }}</td>
                                <td>{{ $withdraw->email }}</td>
                                <td>{{ $withdraw->total_referals }}</td>
                                <td>${{ $withdraw->total_amount_received }}</td>
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
                {{ $list_referral->links() }}
            </div>
        </div>
    </div>

</div>
