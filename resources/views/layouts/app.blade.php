@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp

<html class="loading {{ $configData['theme'] === 'light' ? '' : $configData['layoutTheme'] }}"
	lang="@if (session()->has('locale')){{ session()->get('locale') }}
		@else{{ $configData['defaultLanguage'] }}
		@endif"
	data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}" 
	@if ($configData['theme']==='dark') data-layout="dark-layout" 
	@endif>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description">
	<meta name="keywords">
	<meta name="author">
	<title> @yield('title') | {{ env('APP_NAME', 'IRIS-SPA') }} </title>
	<link rel="apple-touch-icon" href="{{ asset('images/iris-images/jata_negara.png') }}">
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/iris-images/jata_negara.png') }}">

	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
		rel="stylesheet">

	{{-- Include core + vendor Styles --}}
	@include('panels/styles')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
@isset($configData['mainLayoutType'])
@extends((( $configData["mainLayoutType"] === 'horizontal') ? 'layouts.horizontalLayoutMaster' : 'layouts.verticalLayoutMaster' ))
@endisset