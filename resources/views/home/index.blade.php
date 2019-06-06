@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-center">
                    <img src="{{ asset('images/logo.png') }}" class="mx-auto" />
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="content">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h4 class="alert-heading">{{ __('Please check errors') }}:</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('shorten') }}">
                        @csrf
                        <div class="input-group input-group-lg mb-3 mt-3">
                            <input autocomplete="off" type="url" required name="url" value="{{ old('url') }}" id="url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" placeholder="{{ __('Link') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" data-toggle="collapse" href="#collapseOptions" role="button" aria-expanded="false" aria-controls="collapseOptions" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('Options') }}"><i class="fa fa-cog"></i></button>
                                <button class="btn btn-success" type="submit">{{ __('Shorten') }}</button>
                            </div>
                        </div>
                        @if ($errors->has('url'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                        @endif
                        <div class="collapse mb-3{{ $errors->any() ? ' show': ''}}" id="collapseOptions">
                            <div class="card">
                                <div class="card-header">
                                    <strong><i class="fa fa-cog"></i> {{ __('Options') }}</strong>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">{{ __('Title') }}</label>
                                        <input type="text" name="title" value="{{ old('title') }}" class="form-control form-control-sm{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" placeholder="{{ __('Title') }}" autocomplete="off">
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="code">{{ __('Code') }}</label>
                                        <input type="text" name="code" value="{{ old('code') }}" class="form-control form-control-sm{{ $errors->has('code') ? ' is-invalid' : '' }}" id="code" placeholder="{{ __('Code') }}" autocomplete="off">
                                        @if ($errors->has('code'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-sm btn-secondary">
                                            <input type="radio" name="private" value="1" id="privateNo"> {{ __('Private') }}
                                        </label>
                                        <label class="btn btn-sm btn-secondary active">
                                            <input type="radio" checked name="private" value="0" id="privateYes"> {{ __('Public') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
