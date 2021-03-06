@extends('layouts.main')

@section('content')
 <form id='form-user' action="{{ route('users.store') }}" method="post" role="form" enctype="multipart/form-data">
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
                                        <span class="caption-subject bold uppercase">{{trans('users.add_user')}}</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">

                                        {{csrf_field()}}
                                        <div class="form-body">
                                            <div class="form-group form-md-line-input">

                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                                       placeholder="{{trans('users.enter_name')}}">
                                                <label for="form_control_1">{{trans('users.name')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                                                       placeholder="{{trans('users.enter_username')}}">
                                                <label for="form_control_1">{{trans('users.username')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                                       placeholder="{{trans('users.enter_email')}}">
                                                <label for="form_control_1">{{trans('users.email')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"
                                                       placeholder="{{trans('users.enter_phone')}}">
                                                <label for="form_control_1">{{trans('users.phone')}}</label>
                                                <span class="help-block"></span>
                                            </div>

                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"
                                                       placeholder="{{trans('users.enter_mobile')}}">
                                                <label for="form_control_1">{{trans('users.mobile')}}</label>
                                                <span class="help-block"></span>
                                            </div>

                                            <div class="form-group form-md-line-input">
                                                <input type="password" class="form-control"
                                                       placeholder="{{trans('users.enter_password')}} " name="password" id="">
                                                <label for="form_control_1">{{trans('users.password')}}</label>
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

                                            <div class="form-group form-md-line-input">
                                                    <label class="col-md-4 control-label">{{trans('users.news_letter')}}</label>
                                                    <div class="col-md-8">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="news_letter" id="optionsRadios25" value="1" checked="">{{trans('users.news_letter_subscribed')}}
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="news_letter" id="optionsRadios26" value="0" >{{trans('users.news_letter_unsubscribed')}}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php if (!\Entrust::hasRole(['superadmin','c','d'])) : ?>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-12">
                                                        <input type="submit" class="btn btn-success" value="{{trans('users.save')}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif ?>
                                        </div>


                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="portlet light bordered">

                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="icon-settings font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase">{{trans('users.avatar')}}</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">


                                    <div class="form-body">
                                        <div class="form-group form-md-line-input">

                                            <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
                                                    <img src="{{ url('/uploads/avatars/default.png') }}">
                                                </div>
                                                <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-exists"> {{trans('main.change')}} </span>
                                                                <input type="hidden" value="" name="">
                                                                <input type="file" name="avatar" aria-invalid="false" class="valid"> </span>
                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                </div>
                            </div>

                        </div>

                    @role(['superadmin','c','d'])
                        <div class="portlet light bordered">

                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="icon-settings font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase">{{trans('users.user_roles')}}</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">


                                        <div class="form-body">
                                           <div class="form-group form-md-checkboxes">
                                                <label>{{trans('users.roles')}}</label>
                                                <div class="md-checkbox-list">
                                                    @foreach($roles as $role)
                                                        <div class="md-checkbox">
                                                            <input type="checkbox" id="checkbox{{$role->id}}"  name="role[]"
                                                                   value="{{ $role->id }}" class="md-check">
                                                            <label for="checkbox{{$role->id}}" >
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> {{$role->translate('display_name')}}
                                                            </label>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-12">
                                                        <input type="submit" class="btn btn-success" value="{{trans('users.save')}}">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                </div>
                            </div>

                        </div>
                    @endrole

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

        $('#form-user').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                name: {
                    required: true
                },
                username:{
                    required: true
                },
                password: {
                    minlength: 6,
                    required: true
                },

                email: {
                    email:true
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
