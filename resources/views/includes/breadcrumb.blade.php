<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/') }}">{{ __('main.site_title') }}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ url($location) }}">{{ $location_title }}</a>
        </li>



    </ul>

    @if(session()->get('acting_as'))
<div class='row'>
            <div class="alert alert-danger" style="float: left; width:100%">
           <p>{{ trans('main.manage_cpanel') }} : {{ session()->get('restaurant_name') }}
                   <a href="{{ url('acting_as_cancle') }}" class="dropdown-toggle" >
                        <span class="username username-hide-on-mobile"> {{ trans('main.cancle_acting') }} </span>
                        <i class="eye-slash"></i>
                    </a> </p>
            </div>
    </div>
            @endif

</div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif




