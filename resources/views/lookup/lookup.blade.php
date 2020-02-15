@extends('layouts.main')
@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>{{trans('main.error')}}</strong>{{trans('main.error_msg')}}<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row" style="margin-top: 30px;">

       <div class="col-sm-12">
<div class="portlet light bordered">
        <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
               {{trans('main.main_level')}}
        </div>
        <div class="panel-body">
                <!-- BEGIN FORM-->
                    <div class="form-body">

                   <div class="form-group">
                    <div class="col-md-8">
                        <div class="input-icon right">
                            <select  name="mainId"  id="mainId"  class="form-control input-large select2me" data-placeholder="Select...">
                                <option  value="0">{{trans('main.select')}}</option>

                                @foreach($mains as $main)
                                <option  value="{{ $main->id }}">{{ $main->translate('display_text') }}</option>
                                @endforeach


                            </select>
                        </div>
                        <div class="help-block">
                        </div>
                    </div>
                </div>
                        
                            
                    </div>
                    
                    
                    
        </div>
</div>
<!-- end: TEXT AREA PANEL -->
</div>


<div id="panel1" class="portlet light bordered col-sm-12">
  <div class="col-sm-4">
<div class="panel panel-default">
        <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
              <label id="title1" >  </label>
        </div>
        <div class="panel-body">
                <!-- BEGIN FORM-->
                    <div class="form-body">
                        
                   <div class="form-group">
                        <div class="col-md-12">
                            <select id="level1" multiple="false" class="form-control" size=30 style='height: 155px;'>
                            </select>
                        </div>
                    </div>
                       <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-offset-3 col-md-9">
                                <button type="button" class="btn btn-primary" id="new1" >{{trans('main.new_button')}}</button>
                                </div>
                            </div>
                    </div>
                        
                    </div>
                    
                    
                    
        </div>
</div>
<!-- end: TEXT AREA PANEL -->
</div>


<div class="col-sm-8">
<div class="panel panel-default">
        <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
              <label id="title1Update" >  </label>
            </div>

        <div class="panel-body">
                <!-- BEGIN FORM-->
                    <div class="form-body">

                    <form class='form-horizontal form-bordered' id="form1">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  
                 
                      <div class="form-group">
                            <label class="control-label col-md-5">
                                {{trans('main.display_text')}}
                                <i class="fa fa-angle-left"></i>
                                {{__('main.english')}}</label>
                            <div class="col-md-7">
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="name" id="name1" value=''>
                                </div>
                                <div class="help-block">
                                </div>
                            </div>
                        </div>
                    
                    <div class="form-group">
                            <label class="control-label col-md-5">
                                {{trans('main.description')}}
                                <i class="fa fa-angle-left"></i>
                                {{__('main.english')}}</label>
                            <div class="col-md-7">
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="description" id="description1" value=''>
                                </div>
                                <div class="help-block">
                                </div>
                            </div>
                        </div>
                 
                 
                  <div class="form-group">
                            <label class="control-label col-md-5">
                                {{trans('main.display_text')}}
                                <i class="fa fa-angle-left"></i>
                                {{__('main.arabic')}}</label>
                            <div class="col-md-7">
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="name_ar1" id="name_ar1" value=''>
                                </div>
                                <div class="help-block">
                                </div>
                            </div>
                        </div>
                    
                    <div class="form-group">
                            <label class="control-label col-md-5">
                                {{trans('main.description')}}
                                <i class="fa fa-angle-left"></i>
                                {{__('main.arabic')}}</label>
                            <div class="col-md-7">
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="description_ar1" id="description_ar1" value=''>
                                </div>
                                <div class="help-block">
                                </div>
                            </div>
                        </div>
                 
                 
                  <div class="form-group">
                            <label class="control-label col-md-5">
                                {{trans('main.display_text')}}
                                <i class="fa fa-angle-left"></i>
                                {{__('main.turkish')}}</label>
                            <div class="col-md-7">
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="name_tr1" id="name_tr1" value=''>
                                </div>
                                <div class="help-block">
                                </div>
                            </div>
                        </div>
                    
                    <div class="form-group">
                            <label class="control-label col-md-5">
                                {{trans('main.description')}}
                                <i class="fa fa-angle-left"></i>
                                {{__('main.turkish')}}</label>
                            <div class="col-md-7">
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="description_tr1" id="description_tr1" value=''>
                                </div>
                                <div class="help-block">
                                </div>
                            </div>
                        </div>

                <div class="form-actions fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="button" class="btn btn-primary" id="save1" style="display: none;" >{{trans('main.save')}}</button>
                                <button type="button" class="btn btn-primary" id="update1" style="display: none;">{{trans('main.save')}}</button>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                        
                            
                    </div>
                    
                    
                    
        </div>
</div>
<!-- end: TEXT AREA PANEL -->
</div>
</div>



<div id="panel2" class="col-sm-12" style="display: none">
  <div class="col-sm-4">
<div class="panel panel-default">
        <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
              <label id="title2" >  </label>
        </div>
        <div class="panel-body">
                <!-- BEGIN FORM-->
                    <div class="form-body">

                   <div class="form-group">
                        <div class="col-md-12">
                            <select id="level2" multiple="false" class="form-control" size=30 style='height: 155px;'>
                            </select>
                        </div>
                    </div>
                        
                            
                    </div>
                    
                    
                    
        </div>
</div>
<!-- end: TEXT AREA PANEL -->
</div>


</div>




</div>


@endsection

@push('js')
<script>
    $(document).ready(function () {
        $( "#new1" ).click(function() {
           $("#name1").val("");
           $("#description1").val("");
           $("#name_ar1").val("");
           $("#description_ar1").val("");
           $("#name_tr1").val("");
           $("#description_tr1").val("");
           $("#save1").show();
           $("#update1").hide();
           $("#delete1").hide();
         $("#title1Update").html("{{trans('main.add_new')}}");

           
        });
        
        $( "#save1" ).click(function() {
            $("#update1").hide();
            $("#delete1").hide();
           $.ajax({
            type: "POST",
            url:"{{url('/lookup')}}/"+$("#mainId").val()+"",
            data: $("#form1").serialize(),
            success: function(result) {
                var dataList = result;
                dataList = JSON.parse( result );
                $("#level1").append($("<option></option>", {"value":dataList.id, "text":dataList.id+" - "+dataList.display_text}));
                 $.toaster({priority: 'success', message: "{{trans('main.success')}}",title:"{{trans('main.notice')}}"}); 
            }

        });
        });
        
       /* $( "#delete1" ).click(function() {
            if(confirm("{{trans('main.sure_delete')}}")){
                
            $("#update1").hide();
            $("#delete1").hide();
            $("#name1").val("");
           $("#description1").val("");
           
           
           $.ajax({
            type: "GET",
            url:"{{url('/admin')}}/lookup/delete/"+$("#level1").val()+"",
            success: function(result) {
                $("#level1 option[value='"+$("#level1").val()+"']").remove();
                
            }

        });
    }
        });*/
        
       $( "#level1" ).change(function() {
           $("#name1").val("");
           $("#description1").val("");
           $("#save1").hide();
           $("#panel3").hide();
           $.ajax({ url:"{{url('/lookup')}}/"+$("#level1").val()+"" ,
            type:'GET',
            success:function( data ) {
                var dataList = data; // assuming list object
                if ( typeof(data) == "string"){ // but if string
                    dataList = JSON.parse( data );
                } 
                $.each(dataList, function(index,element){
                    $("#name1").val(element.display_text);
                    $("#description1").val(element.description);
                    $("#name_ar1").val(element.display_text_ar);
                    $("#description_ar1").val(element.description_ar);
                    $("#name_tr1").val(element.display_text_tr);
                    $("#description_tr1").val(element.description_tr);
                    $("#title1Update").html("{{trans('main.update_record')}}:"+$("#level1 option:selected").text());
                });
                
                           $("#update1").show();
                           $("#delete1").show();
                           //$("#panel2").show();

            },
            error:function( result ){ console.log(["error", result]); }

             });
             
             $("#level2").empty();
           
            $.ajax({ url:"{{url('/lookup')}}/level/"+$("#level1").val()+"" ,
            type:'GET',
            success:function( data ) {
                var dataList = data; // assuming list object
                if ( typeof(data) == "string"){ // but if string
                    dataList = JSON.parse( data );
                } 
                $.each(dataList['data'], function(index,result){
                    $("#level2").append($("<option></option>", {"value":result.id, "text":result.id+" - "+result.display_text}));
                });
               $("#title2").html("{{trans('main.child_records')}}:"+$("#level1 option:selected").text());

            },
            error:function( result ){ console.log(["error", result]); }

             });
           
       });
       $( "#update1" ).click(function() {
          
            $.ajax({
            type: "put",
            url:"{{url('/lookup')}}/"+$("#level1").val(),
            data: $("#form1").serialize(),
            success: function(result) {
                var dataList = result;
                dataList = JSON.parse( result );
              $("#level1 option:selected").text(dataList.id+" - "+dataList.display_text);
              $("#title1Update").html("{{trans('main.update')}}"+$("#level1 option:selected").text());
              $.toaster({priority: 'success', message: "{{trans('main.success')}}",title:"{{trans('main.notice')}}"});  
            }

        });
});
       
     /************************************************************/
  
       /******************************************************************/
       
           $( "#mainId" ).change(function() {
            $("#level1").empty();
           $("#panel2").hide();
           $("#panel3").hide();
            $.ajax({ url:"{{url('/lookup')}}/level/"+$("#mainId").val()+"" ,
            type:'GET',
            success:function( data ) {
                var dataList = data; // assuming list object
                if ( typeof(data) == "string"){ // but if string
                    dataList = JSON.parse( data );
                } 
                $.each(dataList['data'], function(index,result){
                    $("#level1").append($("<option></option>", {"value":result.id, "text":result.id+" - "+result.display_text}));
                    $("#title1").html("{{trans('main.child_records')}} : "+$("#mainId option:selected").text());
                });
            },
            error:function( result ){ console.log(["error", result]); }

             });

    });
    
    });

</script>
@endpush 