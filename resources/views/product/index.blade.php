@extends('layouts.main')

@section('content')
    
            <!-- The Modal -->

                <!-- END PAGE BAR --> <!-- BEGIN PAGE TITLE-->

                <div class="row" style="margin-top: 30px;">

                    <div class="col-md-12">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">{{trans('main.products')}}</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                @if(!Auth::user()->hasRole('superadmin'))
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="btn-group">
                                                <a href="{{ route('products.create') }}" id="sample_editable_1_new"

                                                   class="btn sbold green">{{trans('main.new_button')}}
                                                    <i class="fa fa-plus"></i>
                                                </a>


                                            </div>
                                        </div>
                                        
                                        <div class="col-md-8"></div>
                                    </div>
                                </div>
                                @endif



                                <table id="data-table"
                                       class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>
                                       
                                        <th>#</th>
                                        <th>{{trans('main.name')}}</th>
                                        <th>{{trans('main.category')}}</th>
                                        <th>{{trans('main.status')}}</th>
                                        <th>{{trans('main.created_at')}}</th>
                                        <th>{{trans('main.control')}}</th>
                                        

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

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                "bInfo": false,
                ajax: {
                    url: '{{url("/products/contentListData")}}',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                },

                columns: [
                    
                    {data: 'id' ,name: 'id', 'class': 'id'},
                    {data: 'name',width:"20%" ,name: 'name', 'class': 'name'},
                    {data: 'category' ,name: 'category', 'class': 'category'},
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
                    url: "{{url('product_activate')}}",
                    method: "get",
                    data: {id: id, active: active},
                    success: function (e) {
                        var message = "";

                        if (active == 0) {
                            message = "{{trans('main.suspends')}}";
                        } else {
                            message = "{{trans('main.activate')}}";
                        }
                        $.toaster({priority: 'success', message: message,title:"{{trans('main.notice')}}"});
                    }

                });

            });
            
            
            $('#data-table').on('click', '.delete', function () {
                var id = $(this).find('.id_hidden').val();
                swal({

                        title: "{{trans('main.sure_delete')}}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{trans('main.yes_delete')}}",
                        cancelButtonText: "{{trans('main.cancle')}}",
                        closeOnConfirm: true
                    },
                    function () {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{url('products')}}" + "/" + id,
                            method: "delete",
                            data: {"_token": "{{ csrf_token() }}"},
                            success: function (data) {
                                if (data.status == true) {

                                    $("#row-" + id).fadeOut();
                                    $("#row-" + id).remove();
                                    $.toaster({priority: 'success', message: "{{trans('main.success_delete')}}",title:"{{trans('main.notice')}}"});
                                }
                                else {
                                    $.toaster({priority: 'error', message: "{{trans('main.error_delete')}}",title:"{{trans('main.error')}}"});
                                }

                            }

                        });


                    });

            });


        });


    </script>
@endpush
