@extends('layouts.main')

@section('content')

    <h1 class="page-title">
        <small></small>
    </h1>

    @if($hours<24)
        <div class="m-heading-1 border-green m-bordered">
            <h3>{{trans('restaurants.suspended')}}</h3>
            <p>  {{trans('restaurants.suspend_trail_message',['hours'=>(24-$hours)])}}
                <a href="{{url('messages/create')}}"> {{trans('main.contact_admin')}} </a>
                . </p>
        </div>
        @else
        <div class="m-heading-1 border-red-flamingo m-bordered">
            <h3>{{trans('restaurants.suspended')}}</h3>
            <p>  {{trans('restaurants.suspend_after_trail_message')}}
                <a href="{{url('messages/create')}}"> {{trans('main.contact_admin')}} </a>
                . </p>
        </div>
    @endif


@stop

@push('css')

@endpush
@push('js')

@endpush
