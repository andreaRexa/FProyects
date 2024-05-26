@extends('layout')

@section('title', 'Listado proyectos')

@section('content')
    <div id="app2">
        <listado-proyectos :proyectos="@json($proyectos)"></listado-proyectos>
    <div>
@endsection