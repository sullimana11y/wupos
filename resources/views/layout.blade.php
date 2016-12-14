<!DOCTYPE html>
<html>
	<head>
		<?php
			header("Cache-Control: no-store, must-revalidate, max-age=0");
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		?>
		<title>Wupos @yield('title')</title>
		{!! Html::meta( null, 'IE=edge', [ 'http-equiv'=>'X-UA-Compatible' ] ) !!}
		{!! Html::meta( null, 'text/html; charset=utf-8', [ 'http-equiv'=>'Content-Type' ] ) !!}
		{!! Html::meta( 'viewport', 'width=device-width, initial-scale=1') !!}

		{!! Html::favicon('favicon.ico') !!}
		
		{{-- Automatic page load progress bar --}}
		{!! Html::script('assets/js/pace/pace.min.js') !!}
		{!! Html::style('assets/js/pace/pace-theme-flash.css') !!}

		{!! Html::style('assets/js/jquery-ui/jquery-ui.min.css') !!}
		{!! Html::style('assets/css/bootstrap.min.css') !!}
		{!! Html::style('assets/css/font-awesome.min.css') !!}
		{!! Html::style('assets/css/bootstrap-theme.min.css') !!}
		{!! Html::style('assets/css/style.css') !!}
		
		<style>
			.page-header{
				margin-top:10px;
			}
			.jumbotron{
				padding:10px 20px !important;
			}
		</style>
		@yield('head')
		
		<!-- Scripts -->
		{!! Html::script('assets/js/jquery-1.11.2.min.js') !!}
		{!! Html::script('assets/js/jquery-ui/jquery-ui.min.js') !!}
		{!! Html::script('assets/js/bootstrap.min.js') !!}
		@yield('scripts')

		<!-- Fonts -->
		{{-- <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> --}}
	</head>

	<body>

		@include('partials/menu')

		<div class="container" style="margin-top:60px;padding-left:10px;padding-right:10px;">

			@include('partials/messages')

			<!-- Contenido cargado desde el blade -->
			@yield('content')
		</div>

	</body>
	
	<foot class="footer navbar-fixed-bottom">
		{{--<div role="navigation" class="navbar {{ !env('APP_DEBUG', false) ? 'navbar-default' : 'navbar-inverse'}}">--}}
			<div class="text-right" style="color: #606060;padding-right:20px;">
				<small>Powered by <i>Shinseiki86</i></small>
			</div>
		{{--</div>--}}
	</foot>
</html>