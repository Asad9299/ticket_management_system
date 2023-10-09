@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mb-3">Create Ticket</h3>
    <form method="POST" action="{{ route('tickets.update', $ticket->id) }}">
    @method('PUT')
    @csrf
    <div class="row mb-3">
        <label for="title" class="col-sm-2 col-form-label">Title</label>
        <div class="col-sm-6">
            <input type="text" name="title" placeholder="Enter title..."  class="form-control" id="title" value="{{ old('title', $ticket->title) }}">
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <label for="description" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-6">
            <textarea name="description" placeholder="Enter description..."  class="form-control ckeditor" id="description" rows="3">{{old('description', $ticket->description)}}</textarea>
        @if ($errors->has('description'))
            <span class="text-danger">{{ $errors->first('description') }}</span>
        @endif
        </div>
    </div>

    <div class="row mb-3">
        <label for="status" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-6">
            <select name="status" id="status" class="form-select">
            <option value="">Select Status...</option>
                @forelse ($statuses  as $status)
                    <option value="{{$status}}" {{ $status == $ticket->status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @empty
                    <option value="">No Data Found...</option>
                @endforelse
            </select>
            @if ($errors->has('status'))
                <span class="text-danger">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <label for="assigned_to" class="col-sm-2 col-form-label">Assigned To</label>
        <div class="col-sm-6">
            <select name="assigned_to" id="assigned_to" class="form-select">
                <option value="">Select User...</option>
                @forelse ($users  as $user)
                    <option value="{{$user->id}}" {{ $user->id == $ticket->assigned_to ? 'selected' : '' }}>{{ $user->name }}</option>
                @empty
                    <option value="">No User Found...</option>
                @endforelse
            </select>
            @if ($errors->has('assigned_to'))
                <span class="text-danger">{{ $errors->first('assigned_to') }}</span>
            @endif
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update Ticket</button>
    <a href="{{ route('tickets.index') }}" class="btn btn-danger">Cancel</a>
    </form>
</div>

<script type="text/javascript">
        CKEDITOR.replace("description", {
            removeButtons: "Strike,Subscript,Superscript,Anchor,Styles,Copy,Paste,Cut",
            removePlugins: "about,image,pastefromword,pastetext,scayt,wsc,blockquote",
        });
</script>

@endsection