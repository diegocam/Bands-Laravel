@extends('layouts.master')

@section('content')
    <a class="btn btn-primary" href="{{route('albums.create')}}">Create New Album</a>
    <br>
    <br>
    <form id="filter_band_form" class="form-inline" role="form">
        <div class="form-group">
            <label for="bandFilter">Filter By Bands:</label>
            <select id="bandFilter" name="band" class="form-control">
                <option value="0">All bands</option>
                @foreach($bands as $band)
                    <option value="{{$band->name}}">{{$band->name}}</option>
                @endforeach
            </select>
        </div>
    </form>
    <br>
    <table class="table" id="albums-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Band Name</th>
            <th>Album Name</th>
            <th>Recorded Date</th>
            <th>Release Date</th>
            <th>Number of Tracks</th>
            <th>Label</th>
            <th>Producer</th>
            <th>Genre</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
@endsection

@push('scripts')
<script>
    $(function () {
        var table = $('#albums-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{  route('albums.datatables') }}',
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            columns: [
                {data: 'id'},
                {data: 'band.name'},
                {data: 'name'},
                {data: 'recorded_date'},
                {data: 'release_date'},
                {data: 'numberoftracks'},
                {data: 'label'},
                {data: 'producer'},
                {data: 'genre'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $("#bandFilter").change(function () {
            var band = $(this).val();
            if (band != 0) {
                table.column(1).search(band).ajax.reload();
            } else {
                table.column(1).search("").ajax.reload();
            }
        });

        $(document).on('click', '.deleteRow', function (e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this album?')) {
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                var id = $(this).data('id');
                var url = '{{ route("albums.delete", ":id") }}';
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
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