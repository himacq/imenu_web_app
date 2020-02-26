@extends('layouts.main')

@section('content')

 <form id='form-data' action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
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
                        <span class="caption-subject font-purple-soft bold uppercase">{{trans('main.edit')}}</span>
                    </div>

                    <div class="actions">
                        <input type="submit" class="btn btn-success" value="{{trans('main.save')}}">
                    </div>

                </div>
                <div class="portlet-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_product" data-toggle="tab" aria-expanded="true"> {{trans('main.product')}} </a>
                        </li>
                        <li>
                            <a href="#tab_ingredients" data-toggle="tab" aria-expanded="false"> {{trans('main.ingredients')}} </a>
                        </li>

                        <li>
                            <a href="#tab_options" data-toggle="tab" aria-expanded="false"> {{trans('main.options')}} </a>
                        </li>



                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_product">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="portlet light bordered">
                                        <div class="portlet-body form">
                                            <div class="form-body">
                                                <div class="form-group form-md-line-input">

                                                    <select name="category_id" class="form-control" style="margin-bottom: 13px;">
                                                        @foreach($categories as $category)
                                                        <option value="{{$category->id}}" {{$product->category_id==$category->id ? "selected" : ""}} >{{$category->translate('name')}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="form_control_1">{{trans('main.category')}}</label>
                                                    <span class="help-block"></span>
                                                </div>
                                            
                                            <div class="form-group form-md-line-input">

                                                <input type="text" class="form-control" name="name" value="{{ $product->name }}"
                                                       placeholder="{{trans('main.enter_name')}}">
                                                <label for="form_control_1">{{trans('main.name')}}</label>
                                                <span class="help-block"></span>
                                            </div>
                                            
                                            
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="name_ar" value="{{ $product->name_ar }}"
                                                       placeholder="{{trans('main.enter_name')}}">
                                                <label for="form_control_1">{{trans('main.name')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.arabic')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                              
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="name_tr" value="{{ $product->name_tr }}"
                                                       placeholder="{{trans('main.enter_name')}}">
                                                <label for="form_control_1">{{trans('main.name')}}
                                                <i class="fa fa-angle-left"></i>
                                                {{__('main.turkish')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="price" value="{{ $product->price }}"
                                                       placeholder="{{trans('main.price')}}">
                                                <label for="form_control_1">{{trans('main.price')}}
                                                </label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="minutes_required" value="{{ $product->minutes_required }}"
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
                                                                <input type="radio" name="isActive" id="optionsRadios25" value="1" 
                                                                       {{$product->isActive==1 ? "checked" : ""}}>{{trans('main.active')}}
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="isActive" id="optionsRadios26" value="0" 
                                                                       {{$product->isActive==0 ? "checked" : ""}}>{{trans('main.not_active')}}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
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
                                                   
                                                    <div class="fileinput fileinput-exists" data-provides="fileinput">
                                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px; line-height: 150px;">
                                                            <img src="{{ url('/uploads/products/'.($product->image?$product->image:'default.png')) }}">
                                                        </div>
                                                        <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-exists"> {{trans('main.change')}} </span>
                                                                <input type="hidden" value="" name="">
                                                                <input type="file" name="image" aria-invalid="false" class="valid"> </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="tab_ingredients">
                              <table id="ingredients_tb" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <th>{{trans('main.name')}}</th>
                                                    <th>{{trans('main.name_ar')}}</th>
                                                    <th>{{trans('main.name_tr')}}</th>
                                                    <th>{{trans('main.status')}}</th>
                                                    <th></th>
                                                    </thead>
                                        <tbody>
                                            <?php $row = 0; ?>
                                            @foreach($product->ingredients as $ingredient)
                                            
                                            <tr id="ingrrow-{{$row}}">

                                            <td>
                                                <input type="hidden"  name="ingr_id[]" value="{{ $ingredient->id }}">
                                                <input type="text" size="8" class="form-control" name="ingr_name[]" value="{{ $ingredient->name }}">
                                            </td>
                                            <td>
                                                <input type="text" size="8" class="form-control" name="ingr_name_ar[]" value="{{ $ingredient->translate('name','ar') }}">
                                            </td>
                                            <td>
                                                <input type="text" size="8" class="form-control" name="ingr_name_tr[]" value="{{ $ingredient->translate('name','tr') }}">
                                            </td>
                                            <td>
                                                <div class="mt-repeater-input mt-radio-inline">
                                                    <label class="mt-radio">
                                                        <input type="radio" name="ingr_is_avtive[{{$row}}][]" 
                                                               {{$ingredient->isActive==1 ? "checked" : ""}}
                                                               value="1"> {{trans('main.isActive')}}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="ingr_is_avtive[{{$row}}][]" 
                                                               {{$ingredient->isActive==0 ? "checked" : ""}}
                                                        value="0"> {{trans('main.not_active')}}
                                                        <span></span>
                                                    </label>
                                                </div>
                                                
                                              
                                            </td>
                                            <td>
                                                <a href="javascript:delete_ingr_record({{$row}},{{ $ingredient->id }});" data-repeater-delete="" id="delete-{{$row}}" class="btn btn-danger delete">
                                                        <i class="fa fa-close"></i> </a>
                                            </td>
                                        </tr>
                                        <?php $row++;?>
                                        @endforeach
                                        
                                     
                                      
                                    </tbody>
                                                </table>
                            
                            <a href="javascript:;" data-repeater-create="" class="btn btn-success " id="repeater-add">
                                            <i class="fa fa-plus"></i>{{trans('main.new_button')}}</a>
                                                
                        </div>
                        <div class="tab-pane fade " id="tab_options">
                              <table id="option_groups_tb" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <th>{{trans('main.name')}}</th>
                                                    <th>{{trans('main.name_ar')}}</th>
                                                    <th>{{trans('main.name_tr')}}</th>
                                                    <th>{{trans('main.status')}}</th>
                                                    <th>{{trans('main.minimum')}}</th>
                                                    <th>{{trans('main.maximum')}}</th>
                                                    <th></th>
                                                    </thead>
                                        <tbody>
                                            <?php $row2 = 0; ?>
                                            <?php $row3 = 0; ?>
                                            @foreach($product->option_groups as $option)
                                            
                                            <tr id="option-group-{{$row2}}">

                                            <td>
                                                <input type="hidden"  name="option_group_id[]" value="{{ $option->id }}">
                                                <input type="text" size="3" class="form-control" name="option_group_name[]" value="{{ $option->name }}">
                                            </td>
                                            <td>
                                                <input type="text" size="3" class="form-control" name="option_group_name_ar[]" value="{{ $option->translate('name','ar') }}">
                                            </td>
                                            <td>
                                                <input type="text" size="3" class="form-control" name="option_group_name_tr[]" value="{{ $option->translate('name','tr') }}">
                                            </td>
                                            <td>
                                                <div class="mt-repeater-input mt-radio-inline">
                                                    <label class="mt-radio">
                                                        <input type="radio" name="option_group_is_avtive[{{$row2}}][]" 
                                                               {{$option->isActive==1 ? "checked" : ""}}
                                                               value="1"> {{trans('main.isActive')}}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="option_group_is_avtive[{{$row2}}][]" 
                                                               {{$option->isActive==0 ? "checked" : ""}}
                                                        value="0"> {{trans('main.not_active')}}
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <input type="text" size="3" class="form-control" name="minimum[]" value="{{ $option->minimum }}">
                                            </td>
                                            
                                            <td>
                                                <input type="text" size="3" class="form-control" name="maximum[]" value="{{ $option->maximum }}">
                                            </td>
                                            <td>
                                                <a href="javascript:delete_option_group_record({{$row2}},{{ $option->id }});" data-repeater-delete="" id="delete-{{$row2}}" class="btn btn-danger delete">
                                                        <i class="fa fa-close"></i> </a>
                                                <a href="javascript:show_hide_options({{$row2}});" class="btn btn-circle blue-steel btn-outline">
                                            <i class="fa fa-plus"></i> {{trans('main.options')}} </a>
                                            </td>
                                        </tr>
                                        
                                        <tr id="options-group-{{$row2}}" class='options-group-rows'>
                                            <td colspan="7" style="background-color: #8eadc7;">
                                                
                                                <table id="options_tb-{{$row2}}" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                    <th>{{trans('main.name')}}</th>
                                                    <th>{{trans('main.name_ar')}}</th>
                                                    <th>{{trans('main.name_tr')}}</th>
                                                    <th>{{trans('main.minutes_required')}}</th>
                                                    <th>{{trans('main.price')}}</th>
                                                    <th></th>
                                                    </thead>
                                                    <tbody>
                                                    <?php $row3 = 0; ?>
                                                    @foreach($option->options as $opt)
                                                    <tr id="option-{{$row2}}-{{$row3}}">

                                                        <td>
                                                            <input type="hidden"  name="thisoption_group_id[]" value="{{ $opt->group_id }}">
                                                            <input type="hidden"  name="option_id[]" value="{{ $opt->id }}">
                                                            <input type="text" size="3" class="form-control" name="option_name[]" value="{{ $opt->name }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" size="3" class="form-control" name="option_name_ar[]" value="{{ $opt->translate('name','ar') }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" size="3" class="form-control" name="option_name_tr[]" value="{{ $opt->translate('name','tr') }}">
                                                        </td>
                                                        

                                                        <td>
                                                            <input type="text" size="3" class="form-control" name="option_minutes_required[]" value="{{ $opt->minutes_required }}">
                                                        </td>

                                                        <td>
                                                            <input type="text" size="3" class="form-control" name="option_price[]" value="{{ $opt->price }}">
                                                        </td>
                                                        <td>
                                                            <a href="javascript:delete_option_record({{$row3}},{{ $opt->id }},{{$row2}});" data-repeater-delete="" id="delete3-{{$row3}}" class="btn btn-danger delete">
                                                                    <i class="fa fa-close"></i> </a>
                                                                    
                                                                    
                                                        </td>
                                                    </tr>
                                                    <?php $row3++; ?>
                                                     @endforeach
                                                     
                                                    </tbody>
                                                </table>
                                                
                                               <input type="hidden" id="option-row-{{$row2}}" value="{{$row3}}">
                                                 <a href="javascript:generate_option_record({{$row2}},{{$option->id}});" data-repeater-create="" class="btn btn-success " id="repeater-option-add">
                                            <i class="fa fa-plus"></i>{{trans('main.new_button')}}</a>
                                            
                                            </td>
                                        </tr>
                                        
                                        <?php $row2++; ?>
                                        @endforeach
                                        
                                     
                                      
                                    </tbody>
                                                </table>
                            
                            <a href="javascript:;" data-repeater-create="" class="btn btn-success " id="repeater-option-groups-add">
                                            <i class="fa fa-plus"></i>{{trans('main.new_button')}}</a>
                                                
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
 

    <script src="{{url('')}}/assets/pages/scripts/components-bootstrap-switch.min.js" type="text/javascript"></script>
    
<script>
$(document).ready(function () {
var row = {{$row}};
var row2 = {{$row2}};
$(".options-group-rows").hide();
 $( "#repeater-add" ).click(function() {
          
          var html = '<tr id="ingrrow-'+row+'"> \n\
  <td><input type="hidden"  name="ingr_id[]" value="-1"><input type="text" size="8" class="form-control" name="ingr_name[]" ></td>\n\
<td><input type="text" size="8" class="form-control" name="ingr_name_ar[]" ></td>\n\
<td><input type="text" size="8" class="form-control" name="ingr_name_tr[]" ></td>\n\
<td> <div class="mt-repeater-input mt-radio-inline"><label class="mt-radio">\n\
<input type="radio" name="ingr_is_avtive['+row+'][]" checked="" value="1"> {{trans("main.isActive")}}<span></span></label>\n\
<label class="mt-radio"><input type="radio" name="ingr_is_avtive['+row+'][]"  value="0"> {{trans("main.not_active")}}<span></span>\n\
</label></div></td>\n\
<td><a href="javascript:delete_record('+row+');" data-repeater-delete="" id="delete" class="btn btn-danger delete"><i class="fa fa-close"></i> </a></td></tr>';
    
    $( "#ingredients_tb" ).append(html);
    row++;
});


 $( "#repeater-option-groups-add" ).click(function() {
          
          var html = '<tr id="option-group-'+row2+'"> \n\
  <td><input type="hidden"  name="option_group_id[]" value="-1">\n\
<input type="text" size="8" class="form-control" name="option_group_name[]" ></td>\n\
<td><input type="text" size="8" class="form-control" name="option_group_name_ar[]" ></td>\n\
<td><input type="text" size="8" class="form-control" name="option_group_name_tr[]" ></td>\n\
<td> <div class="mt-repeater-input mt-radio-inline"><label class="mt-radio">\n\
<input type="radio" name="option_group_is_avtive['+row2+'][]" checked="" value="1"> {{trans("main.isActive")}}<span></span></label>\n\
<label class="mt-radio"><input type="radio" name="option_group_is_avtive['+row2+'][]"  value="0"> {{trans("main.not_active")}}<span></span>\n\
</label></div></td>\n\<td><input type="text" size="3" class="form-control" name="minimum[]" value=""></td>\n\
<td><input type="text" size="3" class="form-control" name="maximum[]" value=""></td>\n\
<td><a href="javascript:delete_record2('+row2+');" data-repeater-delete="" id="delete" class="btn btn-danger delete"><i class="fa fa-close"></i> </a></td></tr>';
    
    $( "#option_groups_tb" ).append(html);
    row2++;
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

    
    function delete_record(id) {
        var row = document.getElementById("ingrrow-"+id);
    row.parentNode.removeChild(row);
    }
    
    function delete_record2(id) {
        var row = document.getElementById("option-group-"+id);
    row.parentNode.removeChild(row);
    var row = document.getElementById("options-group-"+id);
    row.parentNode.removeChild(row);
    }
    
    function delete_record3(group,id) {
        var row = document.getElementById("option-"+group+"-"+id);
    row.parentNode.removeChild(row);
    }
    function show_hide_options(rowid){
        $("#options-group-"+rowid).toggle();
    }
    function delete_ingr_record(rowid,record_id) {
         $.ajax({
                            url: "{{url('product_ingredient')}}" + "/" + record_id,
                            method: "delete",
                            data: {"_token": "{{ csrf_token() }}"},
                            success: function (data) {
                                if (data.status == true) {
                                    $("#ingrrow-" + rowid).fadeOut();
                                    $("#ingrrow-" + rowid).remove();
                                    $.toaster({priority: 'success', message: "{{trans('main.success_delete')}}",title:"{{trans('main.notice')}}"});
                                }
                                else {
                                    $.toaster({priority: 'error', message: "{{trans('main.error_delete')}}",title:"{{trans('main.error')}}"});
                                }

                            }

                        });
                        
        
    }
    
    function delete_option_group_record(rowid,record_id) {
       $.ajax({
                            url: "{{url('product_option_group')}}" + "/" + record_id,
                            method: "delete",
                            data: {"_token": "{{ csrf_token() }}"},
                            success: function (data) {
                                if (data.status == true) {
                                    $("#option-group-" + rowid).fadeOut();
                                    $("#option-group-" + rowid).remove();
                                    $("#options-group-" + rowid).fadeOut();
                                    $("#options-group-" + rowid).remove();
                                    $.toaster({priority: 'success', message: "{{trans('main.success_delete')}}",title:"{{trans('main.notice')}}"});
                                }
                                else {
                                    $.toaster({priority: 'error', message: "{{trans('main.error_delete')}}",title:"{{trans('main.error')}}"});
                                }

                            }

                        });
    }


function delete_option_record(rowid,record_id,group_id) {
       $.ajax({
                            url: "{{url('product_option')}}" + "/" + record_id,
                            method: "delete",
                            data: {"_token": "{{ csrf_token() }}"},
                            success: function (data) {
                                if (data.status == true) {
                                    $("#option-" + group_id+"-"+rowid).fadeOut();
                                    $("#option-" + group_id+"-"+rowid).remove();
                                    $.toaster({priority: 'success', message: "{{trans('main.success_delete')}}",title:"{{trans('main.notice')}}"});
                                }
                                else {
                                    $.toaster({priority: 'error', message: "{{trans('main.error_delete')}}",title:"{{trans('main.error')}}"});
                                }

                            }

                        });
    }



function generate_option_record(rowid,group_id){
var row3 = $( "#option-row-"+rowid ).val();
          var html = '<tr id="option-'+rowid+'-'+row3+'"><td>\n\
  <input type="hidden"  name="thisoption_group_id[]" value="'+group_id+'">\n\
<input type="hidden"  name="option_id[]" value="-1">\n\
<input type="text" size="3" class="form-control" name="option_name[]" value=""></td>\n\
<td><input type="text" size="3" class="form-control" name="option_name_ar[]" value=""></td>\n\
<td><input type="text" size="3" class="form-control" name="option_name_tr[]" ></td>\n\
<td>\n\
<input type="text" size="3" class="form-control" name="option_minutes_required[]"></td>\n\
<td><input type="text" size="3" class="form-control" name="option_price[]"></td>\n\
<td><a href="javascript:delete_record3('+rowid+','+row3+');" data-repeater-delete="" id="delete3-{{$row3}}" class="btn btn-danger delete"><i class="fa fa-close"></i> </a></td></tr>';
    
    $( "#options_tb-"+rowid ).append(html);
    row3++;
    $( "#option-row-"+rowid ).val(row3);
    
}






</script>

@endpush