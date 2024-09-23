 @extends('admin.layouts.master')
 @section('main')
     <div class="container-xxl flex-grow-1 container-p-y p-0">
         <!-- Responsive Datatable -->
         <div>
             <h4 class="py-3 mb-2">
                 <span class="text-muted fw-light">{{ __('Investor Manager') }} /</span> {{ __('Investor List') }}
             </h4>
             <div class="card">
                 <div class="d-flex justify-content-between align-items-center">
                     <h5 class="card-header">{{ __('Investor List') }}</h5>
                     {{-- <button class="dt-button add-new btn btn-primary ms-2 waves-effect waves-light" style="margin-right:24px"
                         type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add">
                         <span>
                             <i class="ti ti-plus ti-xs me-0 me-sm-2"></i>
                             <span class="d-none d-sm-inline-block">{{ __('Add New') }}</span>
                         </span>
                     </button> --}}
                 </div>
                 <div class="card-datatable table-responsive pt-0">
                     <table class="table datatables-ajax dataTable" id="userDatatable">
                         <thead>
                             <tr>
                                 <th>{{ __('User Name') }}</th>
                                 <th>{{ __('Email Address') }}</th>
                                 <th>{{ __('Account Balance') }}</th>
                                 <th>{{ __('Status') }}</th>
                                 <th>{{ __('Created Date') }}</th>
                                 <th style="width:80px">{{ __('Action') }}</th>
                             </tr>
                         </thead>
                     </table>
                 </div>

             </div>
         </div>
         <!-- BEGIN modal -->
         {{-- @include('admin.investors.modal.create') --}}
         @include('admin.investors.modal.update')
         @include('admin.investors.modal.detail')
         <!--  END modal -->
     </div>
 @endsection
 @push('scripts')
     <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
     <script src="{{ asset('libs/lightbox/js/lightbox.js') }}"></script>

     <script>
         var dt_basic_table = $('#userDatatable');
         var dt_basic = null;
         if (dt_basic_table.length) {
             const initAction = () => {
                 // Variable declaration
                 let roles = [];
                 // Show update
                 $(document).on('click', '.btn-edit', function() {
                     const data = getRowData($(this).closest('tr'));
                     user_id = data.id;
                     $('#kt_modal_add_update input[name="id"]').val(data.id);
                     $('#kt_modal_add_update input[name="fullname"]').val(data.fullname);
                     $('#kt_modal_add_update input[name="username"]').val(data.username);
                     $('#kt_modal_add_update input[name="email"]').val(data.email);
                     $('#kt_modal_add_update input[name="balance"]').val(data.balance);
                     $('#kt_modal_add_update select[name="status"]').val(data.status)
                     $('#kt_modal_update').modal('show');
                 })
                 //  delete
                 $(document).on('click', '.btn-delete', function() {
                     const data = getRowData($(this).closest('tr'));
                     Swal.fire({
                         title: 'Do you want to delete?',
                         text: "You will not be able to undo this!",
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonColor: '#3085d6',
                         cancelButtonColor: '#d33',
                         confirmButtonText: 'Delete now!',
                         customClass: {
                             confirmButton: 'btn btn-primary me-1',
                             cancelButton: 'btn btn-label-secondary'
                         },
                         buttonsStyling: false
                     }).then(function(result) {
                         if (result.value) {
                             $.ajax({
                                 url: '{{ route('investor.delete') }}',
                                 type: 'POST',
                                 data: {
                                     id: data.id,
                                     _token: '{{ csrf_token() }}'
                                 },
                                 success: function(response) {
                                     dt_basic.ajax.reload();
                                     Swal.fire({
                                         icon: 'success',
                                         title: 'Delete successful',
                                         customClass: {
                                             confirmButton: 'btn btn-success'
                                         }
                                     });
                                 }
                             });

                         }
                     });
                 })

                 function formatDate(dateStr) {
                     const dateObj = new Date(dateStr);

                     const formattedDate = dateObj.toLocaleString("en-US", {
                         year: "numeric",
                         month: "long",
                         day: "numeric",
                         hour: "2-digit",
                         minute: "2-digit",
                         second: "2-digit",
                         hour12: true
                     });

                     return formattedDate;
                 }
                 const getRowData = (row) => {
                     return dt_basic.row(row).data();
                 }
                 dt_basic = dt_basic_table.DataTable({
                     searchDelay: 500,
                     serverSide: true,
                     processing: true,
                     stateSave: true,
                     ajax: {
                         url: '{{ route('investor.list') }}',
                         type: "POST",
                         data: function(data) {
                             data._token = "{{ csrf_token() }}";
                         },
                         "dataSrc": function(res) {
                             roles = res.role
                             return res.data;
                         }
                     },
                     columns: [{
                             data: 'username'
                         },
                         {
                             data: 'email'
                         },
                         {
                             data: 'balance'
                         },
                         {
                             data: 'status'
                         },
                         {
                             data: 'created_at'
                         },
                         {
                             data: 'action'
                         }
                     ],
                     columnDefs: [{
                             targets: 0,
                             render: function(data, type, row, meta) {
                                 return `<a href="#" class="text-primary text-hover-primary">  ${data ?? ""}  </a>`;

                             }
                         },
                         {
                             targets: 2,
                             render: function(data, type, row) {
                                 return `<span >$${data}  </span>`;
                             },
                         },
                         {
                             targets: 3,
                             render: function(data, type, row) {
                                 return `${data == 0 ? '<span class="badge bg-label-success" text-capitalized="">active</span>' : '<span class="badge bg-label-danger" text-capitalized="">inactive</span>'}`;
                             },
                         }, {
                             targets: 4,
                             render: function(data, type, row, meta) {
                                 return `<span>  ${formatDate(data) }  </a>`;

                             }
                         },
                         {
                             targets: -1,
                             data: null,
                             orderable: false,
                             className: "text-end",
                             render: function(data, type, row) {
                                 return `${ !roles.can_update && !roles.can_delete ? '' :`<div class="dropdown">
                                                                       <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                                                        <div class="dropdown-menu">
                                                                           ${roles.can_update ?`<a class="dropdown-item btn-edit" href="javascript:void(0);"><i class="ti ti-pencil me-2"></i>Sửa</a>` : '' }
                                                                           ${roles.can_delete ? `<a class="dropdown-item btn-delete" href="javascript:void(0);"><i class="ti ti-trash me-2"></i>Xóa</a>` : ''}
                                                                       </div>
                                                                       </div> `}`;
                             },
                         },
                     ],
                     order: [
                         [4, 'desc']
                     ],
                     displayLength: 7,
                     lengthMenu: [10, 25, 50, 75, 100],
                 });
             }
             initAction();
         }
     </script>
 @endpush
