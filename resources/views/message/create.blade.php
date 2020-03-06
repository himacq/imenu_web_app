@extends('layouts.main')

@section('content')
<form class="form-horizontal" id='message-form' action="{{route('messages.store')}}" method="post">
{{csrf_field()}}
<div class="row" style="margin-top: 30px;">

    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold uppercase">{{trans('messages.send_message')}}</span>
                    <span class="caption-helper"></span>
                </div>
              
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('messages.title')}}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="title" id="title" placeholder="{{trans('messages.enter_message_title')}}">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        @role('superadmin')
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('messages.type')}}</label>
                            <div class="col-md-4">
                                
                                <select id="message_type" name="message_type">
                                    <option value='2'>{{trans('messages.restaurants')}}</option>
                                    <option value='3'>{{trans('messages.users')}}</option>
                                </select>
                            
                            </div>
                        </div>
                         @endrole
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('messages.message')}}</label>
                            <div class="col-md-4">
                                <textarea rows="8" class="form-control" name="message" id="message"></textarea>
                            </div>
                        </div>
                        
                       
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-4">
                                <button type="submit" class="btn green">{{trans('main.save')}}</button>
                            </div>
                        </div>
                    </div>
               
                <!-- END FORM-->
            </div>
        </div>

    </div>
</div>

</form>
@endsection 

@push('js')
 <script>
$(document).ready(function () {
            
    $('#message-form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            title: {
                required: true
            },
            message: {
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
