@extends('layouts.main')

@section('content')
 <form id='form-data' action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
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
                                        <span class="caption-subject bold uppercase">{{trans('main.new_button')}}</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">

                                        {{csrf_field()}}
                                        <div class="form-body">
                                            <div class="form-group form-md-line-input">

                                                    <select name="category_id" class="form-control" style="margin-bottom: 13px;">
                                                        @foreach($categories as $category)
                                                        <option value="{{$category->id}}" >{{$category->translate('name')}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="form_control_1">{{trans('restaurants.category')}}</label>
                                                    <span class="help-block"></span>
                                                </div>

                                            <div class="form-group form-md-line-input">

                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                                       placeholder="{{trans('main.enter_name')}}">
                                                <label for="form_control_1">{{trans('main.name')}}</label>
                                                <span class="help-block"></span>
                                            </div>


                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar') }}"
                                                       placeholder="{{trans('main.enter_name')}}">
                                                <label for="form_control_1">{{trans('main.name')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.arabic')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>

                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="name_tr" value="{{ old('name_tr') }}"
                                                       placeholder="{{trans('main.enter_name')}}">
                                                <label for="form_control_1">{{trans('main.name')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.turkish')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="price" value="{{ old('price') }}"
                                                       placeholder="{{trans('main.price')}}">
                                                <label for="form_control_1">{{trans('main.price')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="minutes_required" value="{{ old('minutes_required') }}"
                                                       placeholder="{{trans('main.minutes_required')}}">
                                                <label for="form_control_1">{{trans('main.minutes_required')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                          <div class="form-group form-md-line-input">
                                                    <label class="col-md-3 control-label">{{trans('main.isActive')}}</label>
                                                    <div class="col-md-9">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="isActive" id="optionsRadios25" value="1" checked="">{{trans('main.active')}}
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="isActive" id="optionsRadios26" value="0" >{{trans('main.not_active')}}
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

                                                <textarea  class="form-control" name="description"  rows="5"></textarea>
                                                <label for="form_control_1">{{trans('main.description')}}</label>
                                                <span class="help-block"></span>
                                            </div>


                                                <div class="form-group form-md-line-input">

                                                    <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
                                                            <img src="{{ url('/uploads/products/default.png') }}">
                                                        </div>
                                                        <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-exists"> {{trans('main.change')}} </span>
                                                                <input type="hidden" value="" name="">
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
                price:{
                    required: true
                },
                minutes_required:{
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
