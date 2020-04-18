@extends('layouts.main')

@section('content')
    <form id='form-user'  action="{{ route('restaurants.store') }}" method="post" role="form" enctype="multipart/form-data">
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
                            <span class="caption-subject font-purple-soft bold uppercase">{{trans('restaurants.new_restaurant')}}</span>
                        </div>

                        <div class="actions">
                            <input type="submit" class="btn btn-success" value="{{trans('restaurants.save')}}">
                        </div>

                    </div>
                    <div class="portlet-body">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_profile" data-toggle="tab" aria-expanded="true"> {{trans('restaurants.profile')}} </a>
                            </li>
                            <li>
                                <a href="#tab_classification" data-toggle="tab" aria-expanded="true"> {{trans('restaurants.classifications')}} </a>
                            </li>
                            <li>
                                <a href="#tab_working_details" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.working_details')}} </a>
                            </li>
                                <li>
                                    <a href="#tab_branches" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.branches')}} </a>
                                </li>

                            <li>
                                <a href="#tab_location" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.location')}} </a>
                            </li>


                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="tab_profile">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="portlet light bordered">
                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    <div class="form-group form-md-line-input">

                                                        <input type="text" class="form-control" name="name" id=""
                                                               value="{{ old('name') }}">
                                                        <label for="form_control_1">{{trans('restaurants.name')}}</label>
                                                        <span class="help-block"></span>
                                                    </div>


                                                    @if(isset($users))
                                                        <div class="form-group form-md-line-input">

                                                            <select name="owner_id" class="form-control" style="margin-bottom: 13px;">
                                                                <option value="0" >{{trans('restaurants.owner')}}</option>
                                                                @foreach($users as $user)
                                                                    <option value="{{$user->id}}" >{{$user->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for="form_control_1">{{trans('restaurants.owner')}}</label>
                                                            <span class="help-block"></span>
                                                        </div>
                                                    @endif


                                                    <div class="form-group form-md-line-input">

                                                        <textarea  class="form-control" name="extra_info"  rows="5">{{old('extra_info')}}</textarea>
                                                        <label for="form_control_1">{{trans('restaurants.extra_info')}}</label>
                                                        <span class="help-block"></span>
                                                    </div>

                                                    <div class="form-group form-md-line-input">

                                                        <input type="text" class="form-control" name="phone1" value="{{ old('phone1') }}">
                                                        <input type="text" class="form-control" name="phone2" value="{{ old('phone2') }}">
                                                        <input type="text" class="form-control" name="phone3" value="{{ old('phone2') }}">
                                                        <label for="form_control_1">{{trans('restaurants.phones')}}</label>
                                                        <span class="help-block"></span>
                                                    </div>

                                                    <div class="form-group form-md-line-input">

                                                        <input type="text" class="form-control" name="mobile1" value="{{ old('mobile1') }}">
                                                        <input type="text" class="form-control" name="mobile2" value="{{ old('mobile2') }}">
                                                        <label for="form_control_1">{{trans('restaurants.mobiles')}}</label>
                                                        <span class="help-block"></span>
                                                    </div>

                                                    <div class="form-group form-md-line-input">

                                                        <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                                        <label for="form_control_1">{{trans('restaurants.email')}}</label>
                                                        <span class="help-block"></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="portlet light bordered">
                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    <div class="form-group form-md-line-input">
                                                        <input type="text" class="form-control" name="commision" value="{{ old('commision') }}">

                                                        <label for="form_control_1">{{trans('restaurants.commision')}}</label>
                                                        <span class="help-block"></span>
                                                    </div>

                                                    <div class="form-group form-md-line-input">
                                                        <input type="text" class="form-control" name="discount" value="{{ old('discount') }}">

                                                        <label for="form_control_1">{{trans('restaurants.discount')}}</label>
                                                        <span class="help-block"></span>
                                                    </div>

                                                    <div class="form-group form-md-line-input">
                                                        <label for="form_control_1">{{trans('restaurants.logo')}}</label>
                                                        <span class="help-block"></span>

                                                        <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
                                                            </div>
                                                            <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-exists"> {{trans('restaurants.change')}} </span>
                                                                <input type="hidden" value="" name="">
                                                                <input type="file" name="logo" aria-invalid="false" class="valid"> </span>
                                                            </div>
                                                        </div>

                                                    </div>


                                                    <div class="form-group form-md-line-input">
                                                        <label for="form_control_1">{{trans('restaurants.banner')}}</label>
                                                        <span class="help-block"></span>

                                                        <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 400px; height: 150px; line-height: 150px;">
                                                            </div>
                                                            <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-exists"> {{trans('restaurants.change')}} </span>
                                                                <input type="hidden" value="" name="">
                                                                <input type="file" name="banner" aria-invalid="false" class="valid"> </span>
                                                            </div>
                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade " id="tab_classification">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-body form">
                                                <div class="form-body">



                                                    <div class="form-group form-md-checkboxes">
                                                        <div class="md-checkbox-list">
                                                            @foreach($restaurant_classifications_lookup as $category)
                                                                <div class="md-checkbox">
                                                                    <input type="checkbox" id="checkbox{{$category->id}}"  name="classification[]"
                                                                           value="{{ $category->id }}" class="md-check">
                                                                    <label for="checkbox{{$category->id}}" >
                                                                        <span></span>
                                                                        <span class="check"></span>
                                                                        <span class="box"></span> {{$category->translate('name')}}
                                                                    </label>

                                                                    </div>

                                                            @endforeach

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="tab-pane fade " id="tab_working_details">
                                <table id="working_days_tb" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <th>{{trans('restaurants.day')}}</th>
                                    <th>{{trans('restaurants.start')}}</th>
                                    <th>{{trans('restaurants.end')}}</th>
                                    <th></th>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>

                                <a href="javascript:;" data-repeater-create="" class="btn btn-success " id="repeater-add">
                                    <i class="fa fa-plus"></i>{{trans('main.new_button')}}</a>

                            </div>
                            <div class="tab-pane fade " id="tab_branches">
                                <table id="branches_tb" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <th>{{trans('restaurants.name')}}</th>
                                    <th>{{trans('restaurants.owner')}}</th>
                                    <th></th>
                                    </thead>
                                    <tbody>




                                    </tbody>
                                </table>

                                <a href="javascript:;" data-repeater-create="" class="btn btn-success " id="branch-repeater-add">
                                    <i class="fa fa-plus"></i>{{trans('main.new_button')}}</a>

                            </div>

                            <div class="tab-pane fade " id="tab_location">
                                <input type="hidden" id="lat-span" name="latitude" value="{{old('latitude')}}">
                                <input type="hidden" id="lon-span" name="longitude" value="{{old('longitude')}}">
                                <div id="map" style="width: 100%; height: 350px;">


                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>



        <!-- END SAMPLE FORM PORTLET-->



    </form>
@stop

@push('css')
    <style>
        #map_canvas{
            position: relative !important;
        }

    </style>
    <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGdpn4f1QYHxrQCzInRbPTYhwdMICR_DU&libraries=places&callback=initMap" async defer></script>
    <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>


    <script src="{{url('')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="{{url('')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <!--
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    -->


    <script src="{{url('')}}/assets/pages/scripts/components-bootstrap-switch.min.js" type="text/javascript"></script>

    <script>

        function delete_record(id) {
            var row = document.getElementById("row-"+id);
            row.parentNode.removeChild(row);
        }

        function delete_branch_record(id) {
            var row = document.getElementById("branchrow-"+id);
            row.parentNode.removeChild(row);
        }

        $(document).ready(function () {

            var branch_row = 0;
            $( "#branch-repeater-add" ).click(function() {

                var html = '<tr id="branchrow-'+branch_row+'"><td><input type="text" size="8" class="form-control" name="branch_name[]" ></td>' +
                    '<td><select name="branch_owner_id[]" class="form-control" style="margin-bottom: 13px;"><option value="0" >{{trans('restaurants.owner')}}</option>';
                @foreach($users as $user)
                html+='<option value="{{$user->id}}" >{{$user->name}}</option>';
                @endforeach

            html+='</select></td></div></td><td><a href="javascript:delete_branch_record('+branch_row+');" data-repeater-delete="" id="delete" class="btn btn-danger delete"><i class="fa fa-close"></i> </a></td></tr>';


                $( "#branches_tb" ).append(html);
                branch_row++;
            });

            var row = 0;
            $( "#repeater-add" ).click(function() {
                row++;
                var html = "<tr id='row-"+row+"'><td><select class='form-control valid' name='day_select[]'>";
                @foreach($working_days as $day)
                    html+="<option value='{{$day->id}}'>{{$day->translate('display_text')}}</option>";
                @endforeach
                    html+="</select></td><td>\n\
         <input type='text' size='3' class='form-control timepicker timepicker-24' name='start[]' \n\
            value='{{ $day->start_at }}'></td><td><input type='text' size='3' class='form-control timepicker timepicker-24' name='end[]' value='{{ $day->end_at }}'></td><td>\n\
<a href='javascript:delete_record("+row+");'    class='btn btn-danger delete'><i class='fa fa-close'></i>{{trans('main.delete')}}</a></td></tr>";

                $( "#working_days_tb" ).append(html);
            });



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
