@extends('layouts.master')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-info">
            {{Session::get('message')}}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-md-6">
        <form class="form-horizontal" role="form" method="post" action="{{$form_action}}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ old('id') ?: ( (isset($band) && $band->id) ? $band->id : "") }}">
            <div class="form-group">
                <label for="inputName" class="col-md-4 control-label"><span class="text-danger">*</span> Name:</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputName" placeholder="Name" name="name" value="{{ old('name') ?: ( (isset($band) && $band->name) ? $band->name : "" ) }}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputStartDate" class="col-md-4 control-label">Start Date:</label>
                <div class="col-md-8">
                    <input type="text" class="form-control datepicker" id="inputStartDate" placeholder="Start Date" name="start_date" value="{{ old('start_date') ?: ( (isset($band) && $band->start_date) ? $band->start_date : "") }}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputWebsite" class="col-md-4 control-label">Website:</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputWebsite" placeholder="Website" name="website" value="{{ old('website') ?: ((isset($band) && $band->website) ? $band->website : "") }}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputActive" class="col-md-4 control-label">Active:</label>
                <div class="col-md-8">
                    <select class="form-control" name="still_active">
                        <option value="1" {{ old('still_active') && old('still_active') == 1 ? "selected": ((isset($band) && $band->still_active == 1) ? "selected" : "") }}>Yes</option>
                        <option value="0" {{ old('still_active') && old('still_active') == 0 ? "selected": ((isset($band) && $band->still_active == 0) ? "selected" : "") }}>No</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <input type="submit" class="btn btn-primary" id="submitBtn">
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        @if(isset($albums))
            <h4>Albums</h4>
            <ul>
            @foreach($albums as $album)
                <li><a href="{{route('albums.edit', ['id'=>$album->id])}}">{{$album->name}}</a></li>
            @endforeach
            </ul>
        @endif
    </div>

@endsection
@push('scripts')
<script>
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy'
    });
</script>
@endpush