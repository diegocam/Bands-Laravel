@extends('layouts.master')

@section('content')
    <a class="btn btn-primary" href="{{route('bands.create')}}">Create New Band</a>
    <br>
    <br>
    <table class="table" id="bands-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Start Date</th>
            <th>Website</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
@endsection

@push('scripts')
<script>
    $(function () {
        var table = $('#bands-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/bands/datatables',
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'start_date'},
                {data: 'website'},
                {data: 'still_active'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $(document).on('click', '.deleteRow', function (e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this band?')) {
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                var id = $(this).data('id');
                $.ajax({
                    url: "/bands/delete/" + id,
                    type: "DELETE",
                    data: {_token: csrf_token},
                    success: function () {
                        table.ajax.reload();
                    },
                    error: function (xhr, status, errorThrown) {
                        console.error(xhr.statusText);
                    }
                });
            }
        });
    });
</script>
@endpush