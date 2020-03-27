@extends('layouts.main')

@section('content')



 <form id='form-data' action="{{ url('home/register_restaurant') }}" method="post" enctype="multipart/form-data">
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
                        <input type="submit" class="btn btn-success" value="{{trans('main.save')}}">
                    </div>

                </div>
                <div class="portlet-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_basics" data-toggle="tab" aria-expanded="true"> {{trans('restaurants.basic_info')}} </a>
                        </li>
                        <li>
                            <a href="#tab_branches" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.branches')}} </a>
                        </li>

                        <li>
                            <a href="#tab_questions" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.general_questions')}} </a>
                        </li>



                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_basics">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="portlet light bordered">
                                        <div class="portlet-body form">
                                            <div class="form-body">

                                            <div class="form-group form-md-line-input">

                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                                       placeholder="{{trans('restaurants.name')}}">
                                                <label for="form_control_1">{{trans('restaurants.name')}}</label>
                                                <span class="help-block"></span>
                                            </div>


                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="education_level" value="{{ old('education_level') }}"
                                                       placeholder="{{trans('restaurants.education_level')}}">
                                                <label for="form_control_1">{{trans('restaurants.education_level')}}</label>
                                                <span class="help-block"></span>
                                            </div>

                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="city" value="{{ old('city') }}"
                                                       placeholder="{{trans('restaurants.city')}}">
                                                <label for="form_control_1">{{trans('restaurants.city')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="locality" value="{{ old('locality') }}"
                                                       placeholder="{{trans('restaurants.locality')}}">
                                                <label for="form_control_1">{{trans('restaurants.locality')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}"
                                                           placeholder="{{trans('restaurants.address')}}">
                                                    <label for="form_control_1">{{trans('restaurants.address')}}
                                                    </label>
                                                    <span class="help-block"></span>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control" name="duty" value="{{ old('duty') }}"
                                                           placeholder="{{trans('restaurants.duty')}}">
                                                    <label for="form_control_1">{{trans('restaurants.duty')}}
                                                    </label>
                                                    <span class="help-block"></span>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control" name="starting" value="{{ old('starting') }}"
                                                           placeholder="{{trans('restaurants.starting')}}">
                                                    <label for="form_control_1">{{trans('restaurants.starting')}}
                                                    </label>
                                                    <span class="help-block"></span>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control" name="ending" value="{{ old('ending') }}"
                                                           placeholder="{{trans('restaurants.ending')}}">
                                                    <label for="form_control_1">{{trans('restaurants.ending')}}
                                                    </label>
                                                    <span class="help-block"></span>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                                           placeholder="{{trans('restaurants.email')}}">
                                                    <label for="form_control_1">{{trans('restaurants.email')}}
                                                    </label>
                                                    <span class="help-block"></span>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"
                                                           placeholder="{{trans('restaurants.phone')}}">
                                                    <label for="form_control_1">{{trans('restaurants.phone')}}
                                                    </label>
                                                    <span class="help-block"></span>
                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control" name="business_title" value="{{ old('business_title') }}"
                                                           placeholder="{{trans('restaurants.business_title')}}">
                                                    <label for="form_control_1">{{trans('restaurants.business_title')}}
                                                    </label>
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

                                                    <label for="form_control_1">{{trans('restaurants.id_img')}}</label>
                                                    <span class="help-block"></span>
                                                    <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">

                                                        </div>
                                                        <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-exists"> {{trans('main.change')}} </span>
                                                                <input type="hidden" value="" name="">
                                                                <input type="file" name="id_img" aria-invalid="false" class="valid"> </span>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="form-group form-md-line-input">
                                                    <label for="form_control_1">{{trans('restaurants.license_img')}}</label>
                                                    <span class="help-block"></span>
                                                    <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">

                                                        </div>
                                                        <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-exists"> {{trans('main.change')}} </span>
                                                                <input type="hidden" value="" name="">
                                                                <input type="file" name="license_img" aria-invalid="false" class="valid"> </span>
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
                              <table id="branches_tb" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <th>{{trans('restaurants.name')}}</th>
                                                    <th>{{trans('restaurants.address')}}</th>
                                                    <th></th>
                                                    </thead>
                                        <tbody>




                                    </tbody>
                                                </table>

                            <a href="javascript:;" data-repeater-create="" class="btn btn-success " id="repeater-add">
                                            <i class="fa fa-plus"></i>{{trans('main.new_button')}}</a>

                        </div>
                        <div class="tab-pane fade " id="tab_questions">
                              <table id="option_groups_tb" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <th width="60%">{{trans('restaurants.question_text')}}</th>
                                                    <th>{{trans('restaurants.answer')}}</th>
                                                    </thead>
                                        <tbody>
                                            @foreach($questions as $question)

                                            <tr id="question_row-{{$question->id}}">

                                                <td>
                                                    {{$question->translate('question_text')}}
                                                </td>
                                            <td>
                                                <input type="hidden"  name="question_id[]" value="{{ $question->id }}">

                                                <div class="mt-repeater-input mt-radio-inline">
                                                    <label class="mt-radio">
                                                        <input type="radio" checked name="question_answer[{{$question->id}}][]"   value="1">
                                                        {{trans('main.yes')}}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="question_answer[{{$question->id}}][]" value="0">
                                                        {{trans('main.no')}}
                                                        <span></span>
                                                    </label>
                                                </div>
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



    <!-- END SAMPLE FORM PORTLET-->



</form>
@stop

@push('css')
<style>
  .modal-dialog {
    width: 90%;
    margin: 30px auto;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="{{url('')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush
@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{url('')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->


    <script src="{{url('')}}/assets/pages/scripts/components-bootstrap-switch.min.js" type="text/javascript"></script>

<script>



$(document).ready(function () {
var row = 0;
 $( "#repeater-add" ).click(function() {

          var html = '<tr id="branchrow-'+row+'"> \n\
  <td><input type="text" size="8" class="form-control" name="branch_name[]" ></td>\n\
<td><input type="text" size="8" class="form-control" name="branch_address[]" ></td></div></td>\n\
<td><a href="javascript:delete_record('+row+');" data-repeater-delete="" id="delete" class="btn btn-danger delete"><i class="fa fa-close"></i> </a></td></tr>';

    $( "#branches_tb" ).append(html);
    row++;
});


    $('#form-data').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules: {
            name: {
                required: true
            },
            education_level:{ required:true},
            city:{ required:true},
            locality:{ required:true},
            address:{ required:true},
            duty:{ required:true},
            starting:{ required:true},
            ending:{ required:true},
            email:{ required:true},
            phone:{ required:true},
            business_title:{ required:true}

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


    function delete_record(id) {
        var row = document.getElementById("branchrow-"+id);
    row.parentNode.removeChild(row);
    }



</script>

@endpush
