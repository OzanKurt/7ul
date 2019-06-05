@extends('layouts.app')

@section('content')
    <div class="container">
        @if($link->title)
            <h1>{{ $link->title }}
                <span class="badge badge-secondary" id="realTitle"></span>
            </h1>
        @else
            <h1 id="realTitle"></h1>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-dark" role="alert">
                  <i class="fa fa-external-link-alt"></i>  {{ __('Link') }}:<a href="{{ $link->url }}" rel="nofollow">{{ $link->url }}</a>
                </div>
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-link"></i>  {{ __('Short Link') }}:<a href="{{ $link->link }}" rel="nofollow">{{ $link->link }}</a>
                </div>
                <div class="alert alert-warning" role="alert">
                    <i class="fa fa-cogs"></i>  {{ __('Manage Link') }}:<a href="{{ $link->manage }}" rel="nofollow">{{ $link->manage }}</a>
                </div>
            </div>
            <div class="col-md-4">
                <img src="https://camo.githubusercontent.com/e12db4f7b6cdeb14ea928e01e306ac73a9fb70fa/68747470733a2f2f656e64726f69642e6e6c2f71722d636f64652f4c6966652532306973253230746f6f25323073686f7274253230746f253230626525323067656e65726174696e672532305152253230636f6465732e706e67">
            </div>
        </div>
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

@section('javascript')
<script>
    $(function () {
        axios.get('{{ route('manage.title',[$link->code, $link->password]) }}').then(function(response) {
            console.log(response);
            $('#realTitle').html(response.data);
        }).catch(function (error) {
            console.log(error);
        });
    });

</script>
@endsection
