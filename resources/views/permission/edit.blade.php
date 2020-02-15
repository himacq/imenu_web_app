@extends('layouts.main')

@section('content')
 <form id='form-user' action="{{ route('permissions.update', $permission->id) }}" method="post" role="form">
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
                                        <span class="caption-subject bold uppercase">{{trans('permissions.edit_permission')}}</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                   <div class="form-body">
                                        
                                        <div class="form-group form-md-line-input">

                                                <input type="text" class="form-control" name="name" value="{{ $permission->name  }}"
                                                       placeholder="{{trans('permissions.enter_name')}}">
                                                <label for="form_control_1">{{trans('permissions.name')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="display_name" value="{{  $permission->display_name  }}"
                                                       placeholder="{{trans('permissions.enter_display_name')}}">
                                                <label for="form_control_1">{{trans('permissions.display_name')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.english')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="description" value="{{  $permission->description  }}"
                                                       placeholder="{{trans('permissions.enter_description')}}">
                                                <label for="form_control_1">{{trans('permissions.description')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.english')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                    
                                       
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
                                        <span class="caption-subject bold uppercase">{{trans('main.translations')}}</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                   
                                        
                                        <div class="form-body">
                                            
                                            
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="display_name_ar" value="{{  $permission->display_name_ar }}"
                                                       placeholder="{{trans('permissions.enter_display_name')}}">
                                                <label for="form_control_1">{{trans('permissions.display_name')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.arabic')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="description_ar" value="{{ $permission->description_ar }}"
                                                       placeholder="{{trans('roles.enter_description')}}">
                                                <label for="form_control_1">{{trans('roles.description')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.arabic')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                            
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="display_name_tr" value="{{ $permission->display_name_tr }}"
                                                       placeholder="{{trans('roles.enter_display_name')}}">
                                                <label for="form_control_1">{{trans('roles.display_name')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.turkish')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="description_tr" value="{{ $permission->description_tr }}"
                                                       placeholder="{{trans('roles.enter_description')}}">
                                                <label for="form_control_1">{{trans('roles.description')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.turkish')}}
                                                </label>
                                                <span class="help-block"></span>
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

@endpush
@push('js')

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