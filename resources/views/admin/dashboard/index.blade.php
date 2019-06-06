@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="clearfix mb-2">
                    <a href="{{ route('home') }}" class="btn btn-primary float-right"><i class="fa fa-link"></i> {{ __('Create Link') }}</a>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                            <i class="fa fa-list"></i> {{ __('Links') }}
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach($links as $link)
                            <li class="list-group-item list-group-item-action">
                                <div class="row">
                                    <div class="col-md-2"><span data-toggle="tooltip" data-placement="top" title="{{ __('URL') }}">{{ $link->url }}</span></div>
                                    <div class="col-md-3"><span data-toggle="tooltip" data-placement="top" title="{{ __('Short Link') }}">{{ $link->link }}</span></div>
                                    <div class="col-md-2">
                                        <span data-toggle="tooltip" data-placement="top" title="{{ __('Link Type') }}">{{ $link->type }}</span>
                                    </div>
                                    <div class="col-md-3"><span data-toggle="tooltip" data-placement="top" title="{{ __('Creation Date') }}">{{ $link->created_at }}</span></div>
                                    <div class="col-md-2">
                                        <a href="{{ route('manage',[$link->code, $link->password]) }}" class="btn btn-primary btn-sm"><i class="fa fa-cog"></i> {{ __('Manage') }}</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header font-weight-bold"><i class="fas fa-chart-bar"></i> {{ __('Visit of month') }}</div>
                    <div class="card-body"><canvas id="monthChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $( document ).ready(function() {


            axios.get('{{ route('admin.dashboard.month') }}').then(function(response) {
                var monthChart = $('#monthChart');
                new Chart(monthChart, {
                    type: 'bar',
                    data: {
                        labels: response.data.labels,
                        datasets: [{
                            label: '{{ __('# of Visits') }}',
                            data: response.data.visits,
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

    </script>
@endsection