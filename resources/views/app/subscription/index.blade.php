@extends('adminlte::page')

@section('title', 'Suscripciones')

@section('content_header')
    <h1>Suscripciones</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    @includeIf('app.subscription.partials.crud')
                </div>
                <div class="col-md-8">
                    @includeIf('app.subscription.partials.table')
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('libs/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('libs/select2/css/select2-bootstrap4.min.css') }}">

    <style>
        label.error {
            color: red;
            font-size: 1rem;
            display: block;
            margin-top: 5px;
        }

        input.error {
            border: 1px solid red;
            font-weight: 300;
            color: red;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('libs/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/validate/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/app/subscription/index.js') }}"></script>
@stop