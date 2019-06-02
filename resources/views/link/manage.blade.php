@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-3 mt-3">
                <div class="card">
                    <div class="card-header">
                        <strong>{{ __('Visits') }}</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($visits as $visit)
                        <li class="list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('Country') }}">{{ $visit->country }}</span></div>
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('IP') }}">{{ $visit->ip }}</span></div>
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('OS') }}">{{ $visit->platform }} {{ $visit->platform_version  }}</span></div>
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('Device') }}">{{ $visit->device }}</span></div>
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('Visit Date') }}">{{ $visit->created_at }}</span></div>
                                <div class="col-md-2">
                                    <a href="#detail" class="btn btn-primary btn-sm">{{ __('Detail') }}</a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-3">
                    {{ $visits->onEachSide(5)->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
