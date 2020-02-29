@extends('layouts.main')

@section('content')
<form id='form-user'  action="{{ route('restaurants.update',$restaurant->id) }}" method="post" role="form" enctype="multipart/form-data">
    {{csrf_field()}}
    {{ method_field('PATCH') }}
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
                        <span class="caption-subject font-purple-soft bold uppercase">{{trans('restaurants.edit_restaurant')}}</span>
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
                            <a href="#tab_working_details" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.working_details')}} </a>
                        </li>
                        @if($restaurant->branch_of==NULL)
                        <li>
                            <a href="#tab_branches" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.branches')}} </a>
                        </li>
                        @endif

                        <li>
                            <a href="#tab_location" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.location')}} </a>
                        </li>
                        
                        <li>
                            <a href="#tab_reviews" data-toggle="tab" aria-expanded="false"> {{trans('restaurants.reviews')}} </a>
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
                                                           value="{{ $restaurant->name }}">
                                                    <label for="form_control_1">{{trans('restaurants.name')}}</label>
                                                    <span class="help-block"></span>
                                                </div>
                                                
                                                @role('superadmin')
                                                <div class="form-group form-md-line-input">
                                                    <label for="form_control_1">{{trans('restaurants.owner')}}</label>
                                                    <a target="_blank" href="{{url('users/' . $restaurant->owner->id . '/edit')}}" >{{ $restaurant->owner->name }}</a>
                                                </div>
                                                @endrole
                                                
                                                @role('admin')
                                                @if(isset($users))
                                                <div class="form-group form-md-line-input">

                                                    <select name="owner_id" class="form-control" style="margin-bottom: 13px;">
                                                        @foreach($users as $user)
                                                        <option value="{{$user->id}}" {{$restaurant->owner->id==$user->id ? "selected" : ""}}>{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="form_control_1">{{trans('restaurants.owner')}}</label>
                                                    <span class="help-block"></span>
                                                </div>
                                                @endif 
                                                @endrole
                                                
                                                @if($restaurant->branch_of)
                                                <div class="form-group form-md-line-input">


                                                    <label for="form_control_1">{{trans('restaurants.branch_of')}}</label>
                                                    <a target="_blank" href="{{url('restaurants/' . $restaurant->branch_of . '/edit')}}" >{{ $restaurant->main_branch->name }}</a>
                                                </div>
                                                @endif
                                                <div class="form-group form-md-line-input">

                                                    <select name="category" class="form-control" style="margin-bottom: 13px;">
                                                        @foreach($restaurant_categories as $category)
                                                        <option value="{{$category->id}}" {{$restaurant->category==$category->id ? "selected" : ""}}>{{$category->translate('display_text')}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="form_control_1">{{trans('restaurants.category')}}</label>
                                                    <span class="help-block"></span>
                                                </div>

                                                <div class="form-group form-md-line-input">

                                                    <textarea  class="form-control" name="extra_info"  rows="5">{{$restaurant->extra_info}}</textarea>
                                                    <label for="form_control_1">{{trans('restaurants.extra_info')}}</label>
                                                    <span class="help-block"></span>
                                                </div>

                                                <div class="form-group form-md-line-input">

                                                    <input type="text" class="form-control" name="phone1" value="{{ $restaurant->phone1 }}">
                                                    <input type="text" class="form-control" name="phone2" value="{{ $restaurant->phone2 }}">
                                                    <input type="text" class="form-control" name="phone3" value="{{ $restaurant->phone3 }}">
                                                    <label for="form_control_1">{{trans('restaurants.phones')}}</label>
                                                    <span class="help-block"></span>
                                                </div>
                                                
                                                <div class="form-group form-md-line-input">

                                                    <input type="text" class="form-control" name="mobile1" value="{{ $restaurant->mobile1 }}">
                                                    <input type="text" class="form-control" name="mobile2" value="{{ $restaurant->mobile2 }}">
                                                    <label for="form_control_1">{{trans('restaurants.mobiles')}}</label>
                                                    <span class="help-block"></span>
                                                </div>
                                                
                                                <div class="form-group form-md-line-input">

                                                    <input type="text" class="form-control" name="email" value="{{ $restaurant->email }}">
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
                                                    <input type="text" class="form-control" name="commision" value="{{ $restaurant->commision }}">
                                                    <label for="form_control_1">{{trans('restaurants.commision')}}</label>
                                                    <span class="help-block"></span>
                                                </div>
                                                
                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control" name="discount" value="{{ $restaurant->discount }}">
                                                    <label for="form_control_1">{{trans('restaurants.discount')}}</label>
                                                    <span class="help-block"></span>
                                                </div>
                                                
                                                <div class="form-group form-md-line-input">
                                                    <label for="form_control_1">{{trans('restaurants.logo')}}</label>
                                                    <span class="help-block"></span>

                                                    <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
                                                            <img src="{{ url('/uploads/restaurants/logos/'.($restaurant->logo?$restaurant->logo:'default.png')) }}">
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
                                                            <img src="{{ url('/uploads/restaurants/banners/'.($restaurant->banner?$restaurant->banner:'default.jpg')) }}">
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
                        <div class="tab-pane fade " id="tab_working_details">
                              <table id="working_days_tb" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <th>{{trans('restaurants.day')}}</th>
                                                    <th>{{trans('restaurants.start')}}</th>
                                                    <th>{{trans('restaurants.end')}}</th>
                                                    <th></th>
                                                    </thead>
                                        <tbody>
                                            <?php $row = 0; ?>
                                            @foreach($restaurant->working_details as $restaurantWorkday)
                                            <?php $row++; ?>
                                            <tr id="row-{{$row}}">
                                            <td> 
                                                <select class='form-control valid' name='day_select[]'>";
                                                    @foreach($working_days as $day)
                                                      <option value='{{$day->id}}' {{$restaurantWorkday->working_day==$day->id ? "selected" : ""}}>{{$day->translate('display_text')}}</option>
                                                    @endforeach
                                                </select> </td>
                                            <td>
                                                <input type="text" size="3" class="form-control timepicker timepicker-24" name="start[]" value="{{ $restaurantWorkday->start_at }}">
                                            </td>
                                            <td>
                                                <input type="text" size="3" class="form-control timepicker timepicker-24" name="end[]" value="{{ $restaurantWorkday->end_at }}">
                                            </td>
                                            <td>
                                                <a href="javascript:delete_record({{$row}});" data-repeater-delete="" id="delete-{{$row}}" class="btn btn-danger delete">
                                                        <i class="fa fa-close"></i> {{trans('main.delete')}}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                     
                                      
                                    </tbody>
                                                </table>
                            
                            <a href="javascript:;" data-repeater-create="" class="btn btn-success " id="repeater-add">
                                            <i class="fa fa-plus"></i>{{trans('main.new_button')}}</a>
                                                
                        </div>
                        <div class="tab-pane fade " id="tab_branches">
                            <table id="data-table"
                                       class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>
                                       
                                        <th>#</th>
                                        <th>{{trans('restaurants.name')}}</th>
                                        <th>{{trans('restaurants.owner')}}</th>
                                        <th>{{trans('main.status')}}</th>
                                        <th>{{trans('main.created_at')}}</th>
                                        <th>{{trans('main.control')}}</th>

                                    </tr>
                                    </thead>

                                </table>
                        </div>
                        
                        <div class="tab-pane fade " id="tab_location">
                          

                        </div>
                        <div class="tab-pane fade " id="tab_reviews">
                            <table id="reviews-data-table"
                                       class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>
                                       
                                        <th>{{trans('restaurants.review_text')}}</th>
                                        <th style="width:10%">{{trans('restaurants.review_rank')}}</th>
                                        <th>{{trans('main.created_at')}}</th>

                                    </tr>
                                    </thead>

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
<link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush
@push('js')
        
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

$(document).ready(function () {

var row = {{$row}};
 $( "#repeater-add" ).click(function() {
          row++;
          var html = "<tr id='row-"+row+"'><td><select class='form-control valid' name='day_select[]'>";
          @foreach($working_days as $day)
            html+="<option value='{{$day->id}}'>{{$day->translate('display_text')}}</option>";
          @endforeach
             html+="</select></td><td>\n\
         <input type='text' size='3' class='form-control timepicker timepicker-24' name='start[]' \n\
            value='{{ $day->start_at }}'></td><td><input type='text' size='3' class='form-control timepicker timepicker-24' name='end[]' value='{{ $day->end_at }}'></td><td>\n\
<a href='javascript:delete_record("+row+");' id='delete-{{$row}}'   class='btn btn-danger delete'><i class='fa fa-close'></i>{{trans('main.delete')}}</a></td></tr>";
    
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


$(function () {

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                "bInfo": false,
                ajax: {
                    url: '{{url("/")}}/restaurants/childContentListData',
                    type: 'POST',
                    data: {id: {{$restaurant->id}}},
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                },

                columns: [
                    
                    {data: 'id' ,name: 'id', 'class': 'id'},
                    {data: 'name',width:"20%" ,name: 'name', 'class': 'name'},
                    {data: 'owner',width:"20%" ,name: 'owner', 'class': 'owner'},
                    {data: 'active', name: 'active', orderable: false, "searchable": false},
                    {data: 'created_at', name: 'created_at'},

                    {data: 'control', name: 'control','class': 'control' , orderable: false, "searchable": false}

                ]
            });
            $('#data-table').on('change', '.btnToggle input[type="radio"]', function () {
                // alert($(this).find('input[type="radio"]:checked').val());
                // alert($(this).val())    ;


                var active = $(this).val();
                var id = $(this).parents('.btnToggle').find('.id_hidden').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{url('restaurant_activate')}}",
                    method: "get",
                    data: {id: id, active: active},
                    success: function (e) {
                        var message = "";

                        if (active == 0) {
                            message = "{{trans('restaurants.suspends')}}";
                        } else {
                            message = "{{trans('restaurants.activate')}}";
                        }
                        $.toaster({priority: 'success', message: message,title:"{{trans('main.notice')}}"});
                    }

                });

            });
            
            var reviewTable = $('#reviews-data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                "bInfo": false,
                ajax: {
                    url: '{{url("/")}}/restaurants/reviewsContentListData',
                    type: 'POST',
                    data: {id: {{$restaurant->id}}},
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                },

                columns: [
                    
                    {data: 'review_text' ,name: 'review_text',},
                    {data: 'review_rank' ,width:"5%",name: 'review_rank',},
                    {data: 'created_at', name: 'created_at'},

                ]
            });

            

        });

</script>

@endpush