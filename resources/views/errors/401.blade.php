@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('message', __('Unauthorized'))

@php
    session()->put('url.intended.apiato', url()->current());
    session()->put('url.intended.ajax', url()->previous());
@endphp
