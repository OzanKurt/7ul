@extends('layouts.app')

@section('content')
    <div class="container">

        @if($link->title)
            <h1>{{ $link->title }}
                <span class="badge badge-secondary" id="realTitle" data-toggle="tooltip" data-placement="top" title="{{ __('Real Title') }}"></span>
            </h1>
        @else
            <h1 id="realTitle"></h1>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('Link') }}</span>
                    </div>
                    <input type="text" class="form-control" id="url" value="{{ $link->url }}">
                    <div class="input-group-append">
                        <a class="btn btn-primary" type="button" href="{{ $link->url }}" data-toggle="tooltip" data-placement="top" title="{{ __('Open') }}"><i class="fa fa-external-link-alt"></i></a>
                        <button class="btn btn-success" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('Copy') }}" onclick="copyClipBoard('#url', '{{ __('Link') }}')"><i class="fa fa-copy"></i></button>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('Short Link') }}</span>
                    </div>
                    <input type="text" class="form-control" id="link" value="{{ $link->link }}">
                    <div class="input-group-append">
                        <a class="btn btn-primary" href="{{ $link->link }}" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('Open') }}"><i class="fa fa-link"></i></a>
                        <button class="btn btn-success" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('Copy') }}" onclick="copyClipBoard('#link', '{{ __('Short Link') }}')"><i class="fa fa-copy"></i></button>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('Manage Link') }}</span>
                    </div>
                    <input type="text" class="form-control" id="manage" value="{{ $link->manage }}">
                    <div class="input-group-append">
                        <a class="btn btn-primary" type="button" href="{{ $link->manage }}" data-toggle="tooltip" data-placement="top" title="{{ __('Open') }}"><i class="fa fa-cog"></i></a>
                        <button class="btn btn-success" type="button" data-toggle="tooltip" data-placement="top" title="{{ __('Copy') }}" onclick="copyClipBoard('#manage','{{ __('Manage Link') }}')"><i class="fa fa-copy"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header font-weight-bold">{{ __('Country') }}</div>
                    <div class="card-body"><canvas id="countryChart"></canvas></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header font-weight-bold">{{ __('Platform') }}</div>
                    <div class="card-body"><canvas id="platformChart"></canvas></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header font-weight-bold">{{ __('Browser') }}</div>
                    <div class="card-body"><canvas id="browserChart"></canvas></div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12 mb-3 mt-3">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        <div class="clearfix">
                            <i class="fa fa-users"></i> {{ __('Visits') }}
                            <a href="{{ route('manage.export', [$link->code ,$link->password]) }}" class="float-right"><i class="fa fa-file-excel"></i></a>
                        </div>

                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($visits as $visit)
                        <li class="list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('Country') }}">
                                        @if($visit->country)
                                            {{ $visit->country }}
                                        @else
                                            {{ __('Localhost') }}
                                        @endif
                                    </span></div>
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('IP') }}">{{ $visit->ip }}</span></div>
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('OS') }}">{{ $visit->platform }} {{ $visit->platform_version  }}</span></div>
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('Browser') }}">{{ $visit->browser }} {{ $visit->browser_version }}</span></div>
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('Device') }}">{{ $visit->device }}</span></div>
                                <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('Visit Date') }}">{{ $visit->created_at }}</span></div>
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

@section('javascript')
<script>
    $( document ).ready(function() {
        axios.get('{{ route('manage.title',[$link->code, $link->password]) }}').then(function(response) {
            $('#realTitle').html(response.data);
        }).catch(function (error) {
            console.log(error);
        });

        axios.get('{{ route('manage.browser',[$link->code, $link->password]) }}').then(function(response) {
            var browserChart = $('#browserChart');
            new Chart(browserChart, {
                type: 'pie',
                data: {
                    labels: response.data.labels,
                    datasets: [{
                        label: '{{ __('# of Visits') }}',
                        data: response.data.data,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        colorschemes: {
                            scheme: '{{ config('7ul.colorschemes') }}'

                        }

                    }
                }
            });
        }).catch(function (error) {
            console.log(error);
        });

        axios.get('{{ route('manage.platform',[$link->code, $link->password]) }}').then(function(response) {
            var platformChart = $('#platformChart');
            new Chart(platformChart, {
                type: 'pie',
                data: {
                    labels: response.data.labels,
                    datasets: [{
                        label: '{{ __('# of Visits') }}',
                        data: response.data.data,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        colorschemes: {
                            scheme: '{{ config('7ul.colorschemes') }}'

                        }

                    }
                }
            });
        }).catch(function (error) {
            console.log(error);
        });


        axios.get('{{ route('manage.country',[$link->code, $link->password]) }}').then(function(response) {
            var countryChart = $('#countryChart');
            new Chart(countryChart, {
                type: 'pie',
                data: {
                    labels: response.data.labels,
                    datasets: [{
                        label: '{{ __('# of Visits') }}',
                        data: response.data.data,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        colorschemes: {
                            scheme: '{{ config('7ul.colorschemes') }}'

                        }

                    }
                }
            });
        }).catch(function (error) {
            console.log(error);
        });


    });
    function copyClipBoard(element, title) {
        var copyText = $(element);
        copyText.select();
        document.execCommand("copy");
        iziToast.show({
            message: title + ' {{ __('copied successfully.') }}',
            position: 'bottomRight',
            color: 'blue'
        });
    }
</script>
@endsection
