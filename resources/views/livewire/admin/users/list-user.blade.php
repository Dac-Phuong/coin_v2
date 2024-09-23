<!-- Responsive Datatable -->
<div>
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">{{ __('Permission Manager') }} /</span> {{ __('List User') }}
    </h4>
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">{{ __('List User') }}</h5>
            @can('create-user')
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
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="{{ __('Search...') }}"
                    aria-label="Search..." aria-describedby="basic-addon-search31" fdprocessedid="pjzbzc">
            </div>
        </div>
    
        <div class="table-responsive text-nowrap p-3 mb-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>{{ __('User Name') }}</th>
                        <th>{{ __('Email Address') }}</th>
                        <th>{{ __('Roles') }}</th>
                        <th>{{ __('Created Date') }}</th>
                        <th style="width:80px">{{ __('Action') }}</th>
                    </tr>
                </thead>
    
                <tbody>
                    @if (count($list_users) > 0)
                        @foreach ($list_users as $key => $user)
                            <tr class="odd">
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <div class="dropdown" wire:ignore>
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                        <div class="dropdown-menu">
                                            @can('update-user')
                                                <button data-kt-action="update" data-id={{ $user->id }}
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update"
                                                    class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-pencil me-1"></i> {{ __('Update') }}</button>
                                            @endcan
    
                                            @can('delete-user')
                                                <button wire:click="delete({{ $user->id }})" class="dropdown-item"
                                                    href="javascript:void(0);"><i class="ti ti-trash me-1"></i> {{ __('Delete') }}</button>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12" style="text-align:center; color:red">
                                Không có dữ liệu.
                            </td>
                        </tr>
                    @endif
            </table>
            <div class="mt-3">
                {{ $list_users->links() }}
            </div>
        </div>
    </div>
    
</div>