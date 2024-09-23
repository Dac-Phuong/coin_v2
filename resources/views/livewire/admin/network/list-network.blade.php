  @php
      function formatNumber($number, $decimals = 6)
      {
          $formattedNumber = number_format($number, $decimals);
          return rtrim(rtrim($formattedNumber, '0'), '.');
      }
  @endphp
  <div>
      <!-- Responsive Datatable -->
      <h4 class="py-3 mb-2">
          <span class="text-muted fw-light">{{ __('Network Manage') }} /</span> {{ __('Network List') }}
      </h4>
      <div class="card">
          <div class="d-flex justify-content-between align-items-center">
              <h5 class="card-header">{{ __('Network List') }}</h5>
              <div>
                  @can('create-wallets')
                      <button class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light"
                          style="margin-right:24px" type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add_wallet">
                          <span>
                              <i class="ti ti-plus ti-xs me-0 me-sm-2"></i>
                              <span class="d-none d-sm-inline-block">{{ __('Add New Wallet') }}</span>
                          </span>
                      </button>
                  @endcan
                  @can('create-network')
                      <button class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light"
                          style="margin-right:24px" type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add">
                          <span>
                              <i class="ti ti-plus ti-xs me-0 me-sm-2"></i>
                              <span class="d-none d-sm-inline-block">{{ __('Add New Network') }}</span>
                          </span>
                      </button>
                  @endcan
              </div>
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
                          <th>{{ __('Network Image') }}</th>
                          <th>{{ __('Network Fee') }} ($)</th>
                          <th>{{ __('Status') }}</th>
                          <th>{{ __('Description') }}</th>
                          <th style="width:80px">{{ __('Action') }}</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if (isset($list_network) && count($list_network) > 0)
                          @foreach ($list_network as $key => $network)
                              <tr class="odd">
                                  <td>{{ ++$key }}</td>
                                  <td>{{ $network->network_name }}</td>
                                  <td><img width="50px" src="{{ $network->network_image }}" alt="Uploaded Image"
                                          style="height: 50px"></td>
                                  <td>${{ formatNumber($network->network_price) }}</td>
                                  @if ($network->status == 0)
                                      <td class="text-primary">
                                          {{ __('Active') }}
                                      </td>
                                  @else
                                      <td class="text-success">
                                          {{ __('Inactive') }}
                                      </td>
                                  @endif
                                  <td>{{ $network->description }}</td>
                                  <td>
                                      <div class="dropdown" wire:ignore>
                                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                              data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                          <div class="dropdown-menu">
                                              @can('update-network')
                                                  <button data-kt-action="update" data-id={{ $network->id }}
                                                      data-bs-toggle="modal" data-bs-target="#kt_modal_update"
                                                      class="dropdown-item" href="javascript:void(0);"><i
                                                          class="ti ti-pencil me-1"></i>
                                                      {{ __('Update') }}</button>
                                              @endcan
                                              <a href="{{ url('admin/list-wallets', ['id' => $network->id]) }}"
                                                  class="dropdown-item"><i class="ti ti-eye"></i>
                                                  {{ __('View Wallet') }}</a>
                                              @can('delete-network')
                                                  <button wire:click="delete({{ $network->id }})" class="dropdown-item"
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
                  {{ $list_network->links() }}
              </div>
          </div>
      </div>

  </div>
