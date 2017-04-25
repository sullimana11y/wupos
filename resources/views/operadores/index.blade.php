@extends('layout')
@section('title', '/ Operadores')

@section('scripts')
	{!! Html::script('assets/js/momentjs/moment-with-locales.min.js') !!}
	<script type="text/javascript">
		$(document).ready(function () {
			//Formato de fecha
			var formatDate = function(strDate){
				var strDateFormatted = moment(strDate).format('DD/MM/YYYY hh:mm A');
				return strDateFormatted;
			}

			//.css('background-color', 'orange');
			$('.estado_{{\Wupos\EstadoOperador::PEND_CREAR}}').addClass('warning');
			$('.estado_{{\Wupos\EstadoOperador::CREADO}}').addClass('success');
			$('.estado_{{\Wupos\EstadoOperador::PEND_ELIMINAR}}').addClass('danger');

			//Se da formato a la fecha publicación.
			//var fechaStr = formatDate(fechaPublicacion.text().trim());
			//fechaPublicacion.html(fechaStr);


			$('div.toolbar').html('{{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Exportar Seleccionados',['class'=>'btn btn-success','type'=>'submit', ]) }}');
		});
	</script>
@parent
@endsection

@section('content')
	<h1 class="page-header">Operadores {{$papelera ? 'Eliminados' : ''}}</h1>

	<div class="row well well-sm">
		<!-- Filtrar datos en vista -->
		<div id="frm-find" class="col-xs-12 col-sm-2 col-md-2">
			<a class='btn btn-primary' role='button' data-toggle="collapse" data-target="#filters" href="#" >
				<i class="fa fa-filter" aria-hidden="true"></i> 
				Filtrar <span class="hidden-xs hidden-sm">resultados</span>
			</a>
		</div>
		<div class="col-xs-12 col-sm-8 col-md-6">
			<form>
				<div class="input-group has-feedback">
					<div class="input-group-addon control-label">Filtrar</div>
					{{ Form::text('searchOperador', null, ['class'=>'form-control', 'placeholder'=>'En todos los campos...']) }}
					<span name="btnClear" class="hide glyphicon glyphicon-remove-circle form-control-feedback"></span>
				</div>
			</form>
		</div>

		<!-- Botones -->
		<div id="btns-top" class="col-xs-12 col-sm-2 col-md-4 text-right">

			<!-- botón de crear nuevo reg -->
			@if(in_array(auth()->user()->rol->ROLE_rol , ['admin']) && !$papelera)
			<a class='btn btn-primary' role='button' href="{{ URL::to('operadores/create') }}">
				<i class="fa fa-plus" aria-hidden="true"></i> Nuevo Operador
				<span class="sr-only">Nuevo</span>
			</a>
			<a class='btn btn-warning' role='button' href="{{ URL::to('operadores-borrados') }}">
				<i class="fa fa-trash-o" aria-hidden="true"></i> 
				Papelera
			</a>
			@elseif($papelera)
				<!-- botón de vaciar papelera -->
				{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Vaciar <span class="hidden-xs">Papelera</span>',[
						'class'=>'btn btn-danger',
						'data-toggle'=>'modal',
						'data-id'=>'{% papelera %}',
						'data-descripcion'=>'registros en la papelera',
						'data-action'=>'operadores-borrados/vaciarPapelera',
						'data-target'=>'#pregModalDelete',
					])
				}}
			@endif

			<!-- botón de exportar -->
			<a class='btn btn-success' role='button' href="{{ URL::to('operadores/export/'.\Wupos\EstadoOperador::PEND_CREAR) }}">
				<i class="fa fa-download" aria-hidden="true"></i> Exportar Pend crear
			</a>
		</div>
	</div>
	@include('operadores/index-collapseFormFilters')

	<table id="tbIndex" class="table table-striped table-condensed responsive-utilities">
		<thead>
			<tr class="active">
				<th class="check"></th>
				<th class="codigo">Código</th>
				<th class="cedula">Cédula</th>
				<th class="nombres">Nombre</th>
				<th class="apellidos">Apellido</th>
				<th class="estado">Estado</th>
				<th class="regional">Regional</th>
				<th>Creador</th>
				<th>{{ $papelera ? 'Eliminado' : 'Modif' }}</th>
				<th class="col-xs-1 col-sm-1 col-md-3 col-lg-3">
					Acciones
				</th>
			</tr>
		</thead>
		
		<tbody class="hide">
			@foreach($operadores as $operador)
			<tr class="estado_{{ $operador -> ESOP_id}}">
				<td></td>
				<td>{{ str_pad($operador -> OPER_codigo, 3, '0', STR_PAD_LEFT) }}</td>
				<td>{{ $operador -> OPER_cedula }}</td>
				<td>{{ $operador -> OPER_nombre }}</td>
				<td>{{ $operador -> OPER_apellido }}</td>
				<td>{{ $operador -> estado -> ESOP_descripcion }}</td>
				<td>{{ $operador -> regional -> REGI_nombre }}</td>
				<td>{{ $operador -> OPER_creadopor }}</td>
				<td>{{ $papelera ? $operador-> OPER_eliminadopor : $operador-> OPER_modificadopor }}</td>
				<td>
					@if(!$papelera)
					<!-- Cargar botón Editar -->
					<a class="btn btn-xs btn-info" href="{{ 'operadores/'. $operador->OPER_id . '/edit' }}">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span class="hidden-xs">Editar</span>
					</a>
					@else
					<!-- Cargar botón Restaurar -->
					<a class="btn btn-xs btn-warning" href="{{ 'operadores/'. $operador->OPER_id . '/restore' }}">
						<i class="fa fa-undo" aria-hidden="true"></i> <span class="hidden-xs">Restaurar</span>
					</a>
					@endif

					<!-- carga botón de Borrar -->
					{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs">Borrar</span>',[
							'class'=>'btn btn-xs btn-danger',
							'data-toggle'=> 'modal',
							'data-id'=> $operador->OPER_id,
							'data-descripcion'=> 'cédula '.$operador->OPER_cedula,
							'data-action'=> 'operadores/'.$operador->OPER_id,
							'data-target'=> '#pregModalDelete',
						])
					}}
				</td>
			</tr>
			@endforeach
		</tbody>

		<!--tfoot>
			<td colspan="10">
				<div class="text-center">
					<i class="fa fa-cog fa-spin fa-2x fa-fw" style="vertical-align: middle;"></i> Cargando registros...
				</div>
			</td>
		</tfoot-->
	</table>

	@include('operadores/index-modalExport')
	@include('partials/modalDelete') <!-- incluye el modal del Delete -->
	@include('partials/datatable') <!-- Script para tablas -->
@endsection

	