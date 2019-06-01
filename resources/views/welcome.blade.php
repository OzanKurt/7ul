@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="{{ __('Link') }}">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">{{ __('Shorten') }}</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection
