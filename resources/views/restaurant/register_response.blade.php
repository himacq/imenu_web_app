@extends('layouts.main')

@section('content')
    <form id='form-data' action="{{ url('status-registered-restaurant/'.$restaurant->id) }}" method="post" role="form">
    {{csrf_field()}}
    <!-- Main Content -->
        <div class="row" style="margin-top: 30px;">

            <div class="col-md-12">
                <div class="portlet light bordered">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-social-dribbble font-purple-soft"></i>
                            <span class="caption-subject font-purple-soft bold uppercase">{{trans('restaurants.registered_restaurant')}}
                        <p>
                            {{trans('main.status')}}:{{$restaurant->status_text->translate('display_text')}}
                        </p>


                        </span>
                            <p>
                                <a href="{{url('messages/create')}}"> {{trans('main.contact_admin')}} </a>
                            </p>
                        </div>



                    </div>
                    <div class="portlet-body">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_profile" data-toggle="tab" aria-expanded="true"> {{trans('restaurants.profile')}} </a>
                            </li>
                            <li>
                                <a href="#tab_branches" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.branches')}} </a>
                            </li>

                            <li>
                                <a href="#tab_location" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.location')}} </a>
                            </li>

                            <li>
                                <a href="#tab_general_questions" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.general_questions')}} </a>
                            </li>




                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="tab_profile">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="portlet light bordered">
                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <tbody>
                                                        <tr>
                                                            <td> {{trans('restaurants.name')}} </td>
                                                            <td>
                                                                {{ $restaurant->name }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.status')}} </td>
                                                            <td>
                                                                {{ $restaurant->status_text->translate('display_text') }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.owner')}} </td>
                                                            <td>
                                                                {{ $restaurant->owner->name }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.education_level')}} </td>
                                                            <td>
                                                                {{ $restaurant->education_level }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.city')}} </td>
                                                            <td>
                                                                {{ $restaurant->city }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.locality')}} </td>
                                                            <td>
                                                                {{ $restaurant->locality }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.address')}} </td>
                                                            <td>
                                                                {{ $restaurant->address }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.duty')}} </td>
                                                            <td>
                                                                {{ $restaurant->duty }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.starting')}} </td>
                                                            <td>
                                                                {{ $restaurant->starting }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.ending')}} </td>
                                                            <td>
                                                                {{ $restaurant->ending }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.email')}} </td>
                                                            <td>
                                                                {{ $restaurant->email }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.phone')}} </td>
                                                            <td>
                                                                {{ $restaurant->phone }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td> {{trans('restaurants.business_title')}} </td>
                                                            <td>
                                                                {{ $restaurant->business_title }}
                                                            </td>
                                                        </tr>


                                                        </tbody>
                                                    </table>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="portlet light bordered">
                                            <div class="portlet-body form">
                                                <div class="form-body">

                                                    <div class="form-group form-md-line-input">
                                                        <label for="form_control_1">{{trans('restaurants.distance')}}</label>

                                                        {{ $restaurant->distance}}
                                                    </div>

                                                    <div class="form-group form-md-line-input">
                                                        <label for="form_control_1">{{trans('restaurants.id_img')}}</label>
                                                        <span class="help-block"></span>

                                                        <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
                                                                <img src="{{ url('/uploads/restaurants/ids/'.$restaurant->id_img) }}">
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="form-group form-md-line-input">
                                                        <label for="form_control_1">{{trans('restaurants.license_img')}}</label>
                                                        <span class="help-block"></span>

                                                        <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
                                                                <img src="{{ url('/uploads/restaurants/license/'.$restaurant->license_img) }}">
                                                            </div>

                                                        </div>

                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade " id="tab_branches">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead>
                                                        <th>{{trans('restaurants.name')}}</th>
                                                        <th>{{trans('restaurants.address')}}</th>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($branches as $branch)
                                                            <tr>
                                                                <td> {{$branch->name}} </td>
                                                                <td>
                                                                    {{ $branch->address }}
                                                                </td>
                                                            </tr>
                                                        @endforeach


                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                            </div>

                            <div class="tab-pane fade " id="tab_location">
                                <input type="hidden" id="lat-span" name="latitude" value="{{$restaurant->latitude}}">
                                <input type="hidden" id="lon-span" name="longitude" value="{{$restaurant->longitude}}">
                                <div id="map" style="width: 100%; height: 350px;">


                                </div>
                            </div>
                            <div class="tab-pane fade " id="tab_general_questions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead>
                                                        <th width="60%">{{trans('restaurants.question_text')}}</th>
                                                        <th>{{trans('restaurants.answer')}}</th>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($restaurant->questions_answers as $answer)
                                                            <tr>
                                                                <td> {{$answer->question->translate('question_text')}} </td>
                                                                <td>
                                                                    {{ $answer->answer }}
                                                                </td>
                                                            </tr>
                                                        @endforeach


                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </div>


    </form>
    <!-- END SAMPLE FORM PORTLET-->


@stop

@push('css')
    <style>
        #map_canvas{
            position: relative !important;
        }

    </style>

    <link href="{{url('')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <script>
        var marker;
        function initMap() {
            var center = {lat: {{$center_lat}}, lng: {{$center_long}}};
            var marker_position = {lat: {{$marker_lat}}, lng: {{$marker_long}}};

            var map = new google.maps.Map(document.getElementById('map'), {
                center: center,
                zoom: {{$zoom}}
            });

            marker = new google.maps.Marker({
                position: marker_position,
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(marker) {
                var latLng = marker.latLng;
                document.getElementById('lat-span').value = latLng.lat();
                document.getElementById('lon-span').value = latLng.lng();
            });

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
            });

            function placeMarker(location) {
                if (marker == undefined){
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        animation: google.maps.Animation.DROP,
                    });
                }
                else{
                    marker.setPosition(location);
                }

                document.getElementById('lat-span').value = location.lat();
                document.getElementById('lon-span').value = location.lng();

                map.setCenter(location);

            }

        }


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{\Config::get('settings.google_map_key')}}&libraries=places&callback=initMap" async defer></script>


    <script src="{{url('')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script>
        $(document).ready(function () {

            $('#form-user').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    name: {
                        required: true
                    },

                },
                messages: {
                    //name: "blabla",
                },

                invalidHandler: function (event, validator) { //display error alert on form submit

                },
                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "tnc") { // insert checkbox errors after the container
                        error.insertAfter($('#register_tnc_error'));
                    } else if (element.closest('.input-icon').size() === 1) {
                        error.insertAfter(element.closest('.input-icon'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });


        });
    </script>

@endpush
