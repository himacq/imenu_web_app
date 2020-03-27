@extends('layouts.main')

@section('content')
 <form id='form-user' action="{{ route('users.update', $user->id) }}" method="post" role="form">
                                        {{csrf_field()}}
                                        {{ method_field('PATCH') }}
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
                                        <span class="caption-subject bold uppercase">{{trans('users.edit_user')}}</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">

                                       <div class="form-body">
                                            <div class="form-group form-md-line-input">

                                                <input type="text" class="form-control" name="name" id=""
                                                       value="{{ $user->name }}"
                                                       placeholder="{{trans('users.enter_name')}} ">
                                                <label for="form_control_1">{{trans('users.name')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="username"
                                                       value="{{ $user->username }}"  readonly=""
                                                       id="" placeholder="{{trans('users.enter_username')}}">
                                                <label for="form_control_1">{{trans('users.username')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="email" id=""
                                                       value="{{ $user->email }}" placeholder="{{trans('users.enter_email')}}">
                                                <label for="form_control_1">{{trans('users.email')}}</label>
                                                <span class="help-block"></span>
                                            </div>

                                           <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}"
                                                       placeholder="{{trans('users.enter_phone')}}">
                                                <label for="form_control_1">{{trans('users.phone')}}</label>
                                                <span class="help-block"></span>
                                            </div>

                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}"
                                                       placeholder="{{trans('users.enter_mobile')}}">
                                                <label for="form_control_1">{{trans('users.mobile')}}</label>
                                                <span class="help-block"></span>
                                            </div>

                                            <div class="form-group form-md-line-input">
                                                    <label class="col-md-4 control-label">{{trans('main.isActive')}}</label>
                                                    <div class="col-md-8">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="isActive" id="optionsRadios25"
                                                                       {{$user->isActive==1 ? "checked" : ""}} value="1" >{{trans('main.isActive')}}
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="isActive"
                                                                       {{$user->isActive==0 ? "checked" : ""}}
                                                                id="optionsRadios26" value="0" >{{trans('main.not_active')}}
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
                                           <br/>
                                            <div class="form-group form-md-line-input">
                                                <input type="password" class="form-control" name="password" id="">

                                                <label for="form_control_1">{{trans('users.newpassword')}}</label>
                                                <span class="help-block"></span>
                                            </div>

                                           <?php if (!\Entrust::hasRole('superadmin')) : ?>
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


                @role(['superadmin','c'])
                    <div class="col-md-6">
                        <div class="portlet light bordered">

                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="icon-settings font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase">{{trans('users.roles')}}</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">


                                        <div class="form-body">
                                        <div class="form-group form-md-checkboxes">
                                                <div class="md-checkbox-list">
                                                    @foreach($roles as $role)
                                                        <div class="md-checkbox">
                                                            <input type="checkbox" id="checkbox{{$role->id}}" {{in_array($role->id, $user_roles) ? "checked" : ""}}
                                                            name="role[]"
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
                    </div>
                    @endrole



                </div>

                <!-- END SAMPLE FORM PORTLET-->



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
