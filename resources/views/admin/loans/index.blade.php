@extends('layouts.app')

@section('styles')
    <!-- Custom styles for this page -->
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Librat e Marre</h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Loans</h6>
            <a href="{{ route('admin.users.create') }}" class="d-sm-inline-block btn btn-sm btn-outline-success shadow-sm">
                <i class="fas fa-plus fa-sm text-success-50"></i> Shto nje Huazim
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Perdoruesi</th>
                        <th>Libri</th>
                        <th>Kerkuar me</th>
                        <th>Statusi</th>
                        <th>Data e Huazimit</th>
                        <th>Data Kthimit</th>
                        <th>Nr Kopjeve</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            let $datatable = $('#dataTable');
            let $filterBtn = $('#datatable-filter');
            let $resetFilterBtn = $('#datatable-reset-filter');
            let hasFilters = false;

            let dt = $datatable.DataTable({
                responsive: false,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                stateSave: true,
                ajax: '{{ route('admin.loans.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user.full_name', name: 'full_name', orderable: false},
                    {data: 'book.title', name: 'book.title'},
                    {data: 'requested_at', name: 'requested_at'},
                    {data: 'book_loan_status', name: 'book_loan_status'},
                    {data: 'loan_date', name: 'loan_date'},
                    {data: 'return_date', name: 'return_date'},
                    {data: 'number_copies', name: 'number_copies'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
            });

            $datatable.find('thead tr:eq(1) th').each(function () {
                $('.search-input', this).on('keyup change', function () {
                    if (dt.column(`${this.name}:name`).search() !== this.value) {
                        dt.column(`${this.name}:name`).search(this.value).draw();
                    }
                });
            });

            $filterBtn.click(function () {
                $datatable.find('thead tr:eq(1)').toggle();
            })

            $resetFilterBtn.click(function () {
                dt.state.clear();
                location.reload();
            });

            if (dt.state.loaded()) {
                let state = dt.state.loaded();
                let columns = dt.settings().init().columns;

                dt.columns().every(function (index) {
                    let columnName = columns[index].name,
                        columnSearch = state.columns[index].search,
                        columnSearchValue = columnSearch ? columnSearch.search : null;

                    if (columnSearchValue) {
                        let $field = $(`.search-input[name="${columnName}"]`);

                        if($field.hasClass('select2-hidden-accessible')) {
                            $field.val(columnSearchValue).trigger('change.select2');
                        } else {
                            $field.val(columnSearchValue);
                        }
                        hasFilters = true;
                    }
                });
            }

            if (hasFilters) {
                $datatable.find('thead tr:eq(1)').show();
            }
        });
    </script>
@endsection
