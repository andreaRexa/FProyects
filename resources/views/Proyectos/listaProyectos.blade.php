@extends('layout')

@section('title', 'Listado proyectos')

@section('content')

    <listado-proyectos :proyectos="@json($proyectos)"></listado-proyectos>
    
@endsection