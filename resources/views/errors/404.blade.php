@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __("We can't find that page"))
@section('css')
    <style>
        h1:after {
            -webkit-animation: swing var(--speed) infinite alternate ease-in-out;
            animation: swing var(--speed) infinite alternate ease-in-out;
            content: '404';
            position: absolute;
            top: 0;
            left: 0;
            color: var(--shadow);
            filter: blur(1.5vmin);
            transform: scale(1.05) translate3d(0, 12%, -10vmin) translate(calc((var(--swing-x, 0) * 0.05) * 1%), calc((var(--swing-y) * 0.05) * 1%));
        }
    </style>
@endsection
