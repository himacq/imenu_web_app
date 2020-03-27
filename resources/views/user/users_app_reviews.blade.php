@extends('layouts.main')

@section('content')

                <!-- Main Content -->


                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">{{trans('main.users_app_reviews')}}</span>
                                </div>

                            </div>
                            <div class="portlet-body">

                                <table id="data-table"
                                       class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>

                                        <th>#</th>
                                        <th>{{trans('main.name')}}</th>
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
                    url: "{{url('active_review')}}",
                    method: "get",
                    data: {id: id, active: active},
                    success: function (e) {
                        var message = "";

                        var selected = $('select#statusFilter option:selected').val();
                        if (active == 0) {
                            message = "{{trans('users.suspends')}}";
                            if(selected != "") {
                                var new_url = '{{url("/")}}/user/reviewsContentListData/';
                                table.ajax.url(new_url).load();
                            }

                        } else {

                            message = "{{trans('users.activate')}}";
                            if(selected != "") {
                                var new_url = '{{url("/")}}/user/reviewsContentListData/';
                                table.ajax.url(new_url).load();
                            }

                        }
                        $.toaster({priority: 'success', message: message,title:"{{trans('main.notice')}}"});
                    }

                });

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
                    url: '{{url("/user/reviewsContentListData")}}',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                },

                columns: [

                    {data: 'id' ,name: 'id', 'class': 'id'},
                    {data: 'user',name: 'user', 'class': 'user'},
                    {data: 'review_text',name: 'review_text', 'class': 'review_text'},
                    {data: 'review_rank', name: 'review_rank', 'class': 'review_rank'},
                    {data: 'status', name: 'status', 'class': 'status'},
                    {data: 'created_at', name: 'created_at', 'class': 'created_at'}
                ]
            });


        });


    </script>
@endpush
