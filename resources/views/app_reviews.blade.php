@extends('layouts.main')

@section('content')
    
         <form id='form-data' action="{{ url('home/app_review') }}" method="post" >
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

                            <div class="portlet light bordered">
                                    <div class="portlet-body form">
                                   
                                        {{csrf_field()}}
                                        <div class="form-body">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">{{trans('main.review_text')}}</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="review_text">
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                
                                             </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label">{{trans('main.review_rank')}}</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="review_rank" value="5">
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                
                                             </div>
                                                                                        
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                        <input type="submit" class="btn btn-success" value="{{trans('main.save')}}">
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

                <!-- END PAGE BAR --> <!-- BEGIN PAGE TITLE-->

                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">{{trans('main.app_reviews')}}</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                              
                                <table id="data-table"
                                       class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>
                                       
                                        <th>#</th>
                                        <th>{{trans('main.review_text')}}</th>
                                        <th>{{trans('main.review_rank')}}</th>
                                        <th>{{trans('main.status')}}</th>                                       
                                        <th>{{trans('main.created_at')}}</th>  
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>
            
@stop

@push('css')
<link href="{{url('')}}/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
          rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="{{asset('css/slideShowImage.css')}}">
    <style>
        .btn-default.btn-on-1.active {
            background-color: #006FFC;
            color: white;
        }

        .btn-default.btn-off-1.active {
            background-color: #DA4F49;
            color: white;
        }

    </style>
@endpush
@push('js')
<script src="{{url('')}}/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>

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


        $(function () {
  $('#form-data').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                review_text: {
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

$("input[name='review_rank']").TouchSpin({
                min: 1,
                max: 5,
                step: 1
            });
            
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                "bInfo": false,
                ajax: {
                    url: '{{url("/home/reviewsContentListData")}}',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                },

                columns: [
                    
                    {data: 'id' ,name: 'id', 'class': 'id'},
                    {data: 'review_text',name: 'review_text', 'class': 'review_text'},
                    {data: 'review_rank', name: 'review_rank', 'class': 'review_rank'},
                    {data: 'status', name: 'status', 'class': 'status'},
                    {data: 'created_at', name: 'created_at', 'class': 'created_at'}
                ]
            });

            
        });


    </script>
@endpush
