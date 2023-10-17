@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('message', __($exception->getMessage() ?: 'Service Unavailable'))
