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
    <form class="form-horizontal" role="form" method="post" action="{{$form_action}}">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ old('id') ?: ( (isset($album) && $album->id) ? $album->id : "" )}}">
        <div class="form-group">
            <label for="band" class="col-md-2 control-label"><span class="text-danger">*</span> Band:</label>
            <div class="col-md-3">
                <select id="band" name="band_id" class="form-control">
                    <option value="0">Select a band</option>
                    @foreach($bands as $band)
                        <option value="{{$band->id}}" {{ old('band_id') == $band->id ? "selected": ((isset($album) && $album->band_id == $band->id)?"selected":"") }}>{{$band->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputName" class="col-md-2 control-label"><span class="text-danger">*</span> Name:</label>
            <div class="col-md-3">
                <input type="text" class="form-control" id="inputName" placeholder="Name" name="name" value="{{ old('name') ?: ( (isset($album) && $album->name) ? $album->name : "" ) }}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputRecordedDate" class="col-md-2 control-label">Recorded Date:</label>
            <div class="col-md-3">
                <input type="text" class="form-control datepicker" id="inputRecordedDate" placeholder="Recorded Date" name="recorded_date" value="{{ old('recorded_date') ?: ( (isset($album) && $album->recorded_date) ? $album->recorded_date : "") }}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputReleaseDate" class="col-md-2 control-label">Release Date:</label>
            <div class="col-md-3">
                <input type="text" class="form-control datepicker" id="inputReleaseDate" placeholder="Release Date" name="release_date" value="{{ old('release_date') ?: ((isset($album) && $album->release_date) ? $album->release_date : "") }}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputTracks" class="col-md-2 control-label">Number of Tracks:</label>
            <div class="col-md-3">
                <input type="number" class="form-control" id="inputTracks" placeholder="Number of Tracks" name="numberoftracks" value="{{ old('numberoftracks') ?: ((isset($album) && $album->numberoftracks) ? $album->numberoftracks : "") }}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputLabel" class="col-md-2 control-label">Label:</label>
            <div class="col-md-3">
                <input type="text" class="form-control" id="inputLabel" placeholder="Label" name="label" value="{{ old('label') ?: ((isset($album) &&$album->label) ? $album->label : "") }}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputProducer" class="col-md-2 control-label">Producer:</label>
            <div class="col-md-3">
                <input type="text" class="form-control" id="inputProducer" placeholder="Producer" name="producer" value="{{ old('producer') ?: ((isset($album) &&$album->producer) ? $album->producer : "") }}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputGenre" class="col-md-2 control-label">Genre:</label>
            <div class="col-md-3">
                <input type="text" class="form-control" id="inputGenre" placeholder="Genre" name="genre" value="{{ old('genre') ?: ((isset($album) && $album->genre) ? $album->genre : "") }}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2"></div>
            <div class="col-md-3">
                <input type="submit" class="btn btn-primary" id="submitBtn">
            </div>
        </div>
    </form>

@endsection
@push('scripts')
<script>
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy'
    });
</script>
@endpush