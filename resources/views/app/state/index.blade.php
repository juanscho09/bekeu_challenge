@extends('adminlte::page')

@section('title', 'Importar estados')

@section('content_header')
    <h1>Importar estados</h1>
@stop

@section('content')
    <section class="content">
        <div class="container">
            <div class="card bg-light">
                <div class="card-body text-center ">
                    <form action="{{ route('states.store') }}" method="POST">
                        @csrf
                        <button class="btn btn-info" type="button" id="import_states" >Iniciar importaci&oacute;n</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    
@stop

@section('js')
    <script src="{{ asset('js/app/state/index.js') }}"></script>
@stop