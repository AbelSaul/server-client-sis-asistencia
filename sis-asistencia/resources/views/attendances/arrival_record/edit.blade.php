@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Asistencia
        </h1>
   </section>
   
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                
                  {!! Form::model($attendance, ['url' => ['attendances/arrival_record', $attendance->id], 'method' => 'patch']) !!}
                        @include('attendances.arrival_record.fields_edit')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection