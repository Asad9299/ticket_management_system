@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mb-3">Create Ticket</h3>
    <form method="POST" action="{{ route('tickets.store') }}">
    @csrf
    <div class="row mb-3">
        <label for="title" class="col-sm-2 col-form-label">Title</label>
        <div class="col-sm-6">
            <input type="text" name="title" placeholder="Enter title..."  class="form-control" id="title" value="{{ old('title') }}">
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <label for="description" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-6">
            <textarea name="description" placeholder="Enter description..."  class="form-control ckeditor" id="description" rows="3">{{old('description')}}</textarea>
        @if ($errors->has('description'))
            <span class="text-danger">{{ $errors->first('description') }}</span>
        @endif
        </div>
    </div>

    <div class="row mb-3">
        <label for="assigned_to" class="col-sm-2 col-form-label">Assigned To</label>
        <div class="col-sm-6">
            <select name="assigned_to" id="assigned_to" class="form-select">
                <option value="">Select User...</option>
                @forelse ($users  as $user)
                    <option value="{{$user->id}}">{{ $user->name }}</option>
                @empty
                    <option value="">No User Found...</option>
                @endforelse
            </select>
            @if ($errors->has('assigned_to'))
                <span class="text-danger">{{ $errors->first('assigned_to') }}</span>
            @endif
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Create Ticket</button>
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