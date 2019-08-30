@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>HORAS NO TRABAJADAS</b></div>
                <div class="panel-body">
                    <canvas id="canvas-asistencias" height="280" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>N° EMPLEADOS POR CARGO</b></div>
                <div class="panel-body">
                    <canvas id="canvas-cargos-empleados" height="280" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
