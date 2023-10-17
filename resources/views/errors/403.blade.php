@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('message', __($exception->getMessage() ?: 'Forbidden'))

@php
    session()->put('url.intended.apiato', url()->current());
    session()->put('url.intended.ajax', url()->previous());
@endphp