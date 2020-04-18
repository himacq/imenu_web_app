@extends('layouts.main')

@section('content')
@if($copy)
<form id='form-data' action="{{ route('classifications.store_copy') }}" method="post" enctype="multipart/form-data">
     {{csrf_field()}}
@else
 <form id='form-data' action="{{ route('classifications.update', $classification->id) }}" method="post" enctype="multipart/form-data">
     {{csrf_field()}}
    {{ method_field('PATCH') }}
 @endif
                <!-- Main Content -->
                <div class="row" style="margin-top: 30px;">

                    <div class="col-md-6">
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

                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="icon-settings font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase">{{trans('main.edit')}}</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">

                                        <div class="form-body">
                                            <div class="form-group form-md-line-input">

                                                <input type="text" class="form-control" name="name" value="{{ $classification->name }}"
                                                       placeholder="{{trans('main.enter_name')}}">
                                                <label for="form_control_1">{{trans('main.name')}}</label>
                                                <span class="help-block"></span>
                                            </div>


                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="name_ar" value="{{ $classification->name_ar }}"
                                                       placeholder="{{trans('main.enter_name')}}">
                                                <label for="form_control_1">{{trans('main.name')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.arabic')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>

                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="name_tr" value="{{ $classification->name_tr }}"
                                                       placeholder="{{trans('main.enter_name')}}">
                                                <label for="form_control_1">{{trans('main.name')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.turkish')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                          <div class="form-group form-md-line-input">
                                                    <label class="col-md-3 control-label">{{trans('main.isActive')}}</label>
                                                    <div class="col-md-9">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="isActive" id="optionsRadios25" value="1"
                                                                       {{$classification->isActive==1 ? "checked" : ""}} value="1" >{{trans('main.active')}}
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="isActive" id="optionsRadios26" value="0"
                                                                       {{$classification->isActive==0 ? "checked" : ""}} >{{trans('main.not_active')}}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>

                                </div>
                            </div>

                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="portlet light bordered">

                            <div class="portlet light bordered">
                                <div class="portlet-body form">

                                        <div class="form-body">

                                                <div class="form-group form-md-line-input">

                                                    <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
                                                            <img src="{{ url('/uploads/classifications/'.($classification->image?$classification->image:'default.jpg')) }}">
                                                        </div>
                                                        <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-exists"> {{trans('main.change')}} </span>
                                                                <input type="hidden" value="{{$classification->image}}" name="old_image">
                                                                <input type="file" name="image" aria-invalid="false" class="valid"> </span>
                                                        </div>
                                                    </div>

                                                </div>


                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-12">
                                                        <input type="submit" class="btn btn-success" value="{{trans('main.save')}}">
                                                    </div>
                                                </div>
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
<link href="{{url('')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />

@endpush
@push('js')
    <script src="{{url('')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
$(document).ready(function () {

        $('#form-data').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                name: {
                    required: true
                },
                display_name:{
                    required: true
                }



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
