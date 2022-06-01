@extends('layouts.master')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">
                App Settings
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('settings.update') }}" method="post">
                @csrf
                @method('PUT')
                <label for="app_name" class="form-label">App name</label>
                <div class="input-group mb-2">
                    <input type="text" name="app_name" class="form-control" id="app_name"
                        aria-describedby="basic-addon3" value="{{ $app->app_name }}" required>
                </div>

                <label for="company_name" class="form-label">Company name</label>
                <div class="input-group mb-2">
                    <input type="text" name="company_name" class="form-control" id="company_name"
                        aria-describedby="basic-addon3" value="{{ $app->company_name }}" required>
                </div>

                <div class="d-flex mt-4 justify-content-end">
                    <button type="submit" class="btn btn-sm btn-success mr-2">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection