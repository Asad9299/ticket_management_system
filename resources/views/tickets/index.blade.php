@extends('layouts.app')

@section('content')
    @if(Session::has('success'))
        <p class="alert alert-success">{{ Session::get('success') }}</p>
    @endif
    <h1>My Tickets</h1>
    <div class="container row col-md-2">
        <a href="{{ route('tickets.create') }}" class="btn btn-dark mb-2">Add Ticket</a>
    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Status</th>
                <th width="100px">Action</th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>
</body>

<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('tickets.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
  });
</script>

</html>
@endsection
