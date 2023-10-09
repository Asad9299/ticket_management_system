@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            
            <div class="card-header">
                <h3 class="card-title">{{ $ticket->title.' Details' }}</h3>
                <a href="{{ route('tickets.index') }}" class="btn btn-success float-sm-end">Back to List</a>

                <a href="{{ route('tickets.close', $ticket->id) }}" class="btn btn-danger float-sm-start" onclick="return confirm('Are you sure you want to close this Ticket?')">Close Ticket</a>

            </div>
            
            <div class="card-body">
                <div class="dt-responsive">
                    <table class="table table-striped table-bordered detail-view">
                        <tr>
                            <th style="width: 300px;">Title</th>
                            <td>{{ $ticket->title }}</td>
                        </tr>
                        <tr>
                            <th style="width: 300px;">Description</th>
                            <td>{!! $ticket->description !!}</td>
                        </tr>
                        <tr>
                            <th style="width: 300px;">Status</th>
                            <td>{{ ucfirst($ticket->status) }}</td>
                        </tr>
                        <tr>
                            <th style="width: 300px;">Assigned By</th>
                            <td>{{ $ticket->assigned_by }}</td>
                        </tr>
                        <tr>
                            <th style="width: 300px;">Created At</th>
                            <td>{{ $ticket->created_at->format('d F Y g:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection