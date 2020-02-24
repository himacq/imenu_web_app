@extends('layouts.main')

@section('content')
 <form id='form-user' action="{{ route('users.updateUserInfo') }}" method="post" role="form">
                                        {{csrf_field()}}
                <!-- Main Content -->
                <div class="row" style="margin-top: 30px;">
                
                    
                    <div class="col-md-12">
                        
                        <div class="portlet box blue">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-gift"></i>{{trans('users.edit_user')}}</div>
                                                
                                            </div>
                                            <div class="portlet-body form">
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
                                                <!-- BEGIN FORM-->
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                 <div class="form-group form-md-line-input">

                                                                    <input type="text" class="form-control" name="name" id=""
                                                                           value="{{ $user->name }}"
                                                                           placeholder="{{trans('users.enter_name')}} ">
                                                                    <label for="form_control_1">{{trans('users.name')}}</label>
                                                                    <span class="help-block"></span>
                                                                </div>
                                                            </div>
                                                            <!--/span-->
                                                            <div class="col-md-6">
                                                                <div class="form-group form-md-line-input">
                                                                <input type="text" class="form-control" name="username"
                                                                       value="{{ $user->username }}"  readonly=""
                                                                       id="" placeholder="{{trans('users.enter_username')}}">
                                                                <label for="form_control_1">{{trans('users.username')}}</label>
                                                                <span class="help-block"></span>
                                                            </div>
                                                            </div>
                                                            <!--/span-->
                                                        </div>
                                                        <!--/row-->
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group form-md-line-input">
                                                                    <input type="text" class="form-control" name="email" id=""
                                                                           value="{{ $user->email }}" placeholder="{{trans('users.enter_email')}}">
                                                                    <label for="form_control_1">{{trans('users.email')}}</label>
                                                                    <span class="help-block"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                           
                                                                <div class="form-group form-md-line-input">
                                                                     <input type="text" class="form-control" name="phone" value="{{ $user->phone }}"
                                                                            placeholder="{{trans('users.enter_phone')}}">
                                                                     <label for="form_control_1">{{trans('users.phone')}}</label>
                                                                     <span class="help-block"></span>
                                                                 </div>
                                                                
                                                                </div>
                                                        </div>
                                                        <div  class="row">
                                                            <div class="col-md-6">
                                                              
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}"
                                                       placeholder="{{trans('users.enter_mobile')}}">
                                                <label for="form_control_1">{{trans('users.mobile')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                            </div>
                                                            <div class="col-md-6">
                                            <div class="form-group form-md-line-input">
                                                    <label class="col-md-4 control-label">{{trans('users.news_letter')}}</label>
                                                    <div class="col-md-8">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="news_letter" id="optionsRadios25" 
                                                                       value="1" {{$user->news_letter==1 ? "checked" : ""}} >
                                                                {{trans('users.news_letter_subscribed')}}
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="news_letter" id="optionsRadios26" 
                                                                       value="0" {{$user->news_letter==0 ? "checked" : ""}}  >{{trans('users.news_letter_unsubscribed')}}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                            </div>
                                                            </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6">
                                            <div class="form-group form-md-line-input">
                                                <input type="password" class="form-control" name="password" id="">

                                                <label for="form_control_1">{{trans('users.newpassword')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                                            </div>
                                                        </div>
                                                           
                                                        </div>
                                                    <div class="form-actions right">
                                                        <button type="submit" class="btn blue">
                                                            <i class="fa fa-check"></i> {{trans('users.save')}}</button>
                                                    </div>
                                            
                                                <!-- END FORM-->
                                            </div>
                                        </div>
                        
                        
                   
                                        </div>

                    </div>
                    
                
   
               

    </form>
@stop

@push('css')

@endpush
@push('js')

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
                email: {
                    email:true
                },
                
                
                
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