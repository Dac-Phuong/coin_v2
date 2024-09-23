<div>
    <div class="col-xl-12">
        <h4 class="py-3 mb-2">
            <span class="text-muted fw-light">{{ __('Settings Manage') }} /</span> {{ __('Settings') }}
        </h4>
        <div class="nav-align-top nav-tabs-shadow mb-6">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-top-withdraw" aria-controls="navs-top-withdraw"
                        aria-selected="true">{{ __('Referral') }}</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false"
                        tabindex="-1">{{ __('Referral') }}</button>
                </li> --}}
                {{-- <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false"
                        tabindex="-1">Messages</button>
                </li> --}}
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="navs-top-withdraw" role="tabpanel">

                    <form class="form" action="#" wire:submit.prevent="updateReferral"
                        enctype="multipart/form-data">
                        <h5 class="card-header mb-2 mt-0">
                            {{ __('Add/Edit commissions') }}
                        </h5>
                        <div class="mb-3 col-xl-3">
                            <label class="form-label" for="basic-icon-default">{{ __('Commission (%)') }}</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="basic-icon-default" wire:model.defer="commissions"
                                    class="form-control" placeholder="" fdprocessedid="40irmg">
                            </div>
                            @error('commissions')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                            data-kt-users-modal-action="updateReferral">
                            <span class="indicator-label">{{ __('Save') }}</span>
                            <span class="indicator-progress" wire:loading="" wire:target="updateReferral">
                                ...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </form>
                </div>
                {{-- <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                    <form class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
                        <h5 class="card-header mb-2 mt-0">
                            {{ __('Add/Edit withdrawal fees') }}
                        </h5>
                        <div class="mb-3 col-xl-3">
                            <label class="form-label" for="basic-icon-default">{{ __('Withdrawal fees') }} ($)</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="basic-icon-default" wire:model.defer="amount_money"
                                    class="form-control" placeholder="" fdprocessedid="40irmg">
                            </div>
                            @error('amount_money')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-xl-3">
                            <label class="form-label" for="basic-icon-default">{{ __('Min withdrawal amount') }}
                                ($)</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="basic-icon-default" wire:model.defer="min_amount"
                                    class="form-control" placeholder="" fdprocessedid="40irmg">
                            </div>
                            @error('min_amount')
                                <span class="error text-danger fs-7">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                            data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('Save') }}</span>
                            <span class="indicator-progress" wire:loading="" wire:target="submit">
                                ...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </form>
                </div> --}}
                <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
                    <p>
                        Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                        cupcake gummi
                        bears
                        cake chocolate.
                    </p>
                    <p class="mb-0">
                        Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                        roll icing
                        sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly jelly-o tart
                        brownie
                        jelly.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
