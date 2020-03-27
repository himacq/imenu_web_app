@extends('layouts.main')

@section('content')
    <form id='form-data' action="{{ url('reports/support') }}" method="post" >
    @csrf
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
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">{{$location_title}}</span>
                            </div>

                        </div>

                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span  class="help-block"> {{trans('reports.select_date')}}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-large date-picker input-daterange"
                                                 data-date-format="yyyy-mm-dd">
                                                <input type="text" required class="form-control" value="{{$from}}" name="from" autocomplete="off">
                                                <span class="input-group-addon"> {{trans('reports.to')}} </span>
                                                <input type="text" required class="form-control" value="{{$to}}" name="to" autocomplete="off">

                                            </div>

                                        </div>

                                        <label class="control-label col-md-3">
                                            <button type="submit" class="btn btn-primary">{{trans('reports.show')}}
                                            </button>
                                        </label>
                                    </div>


                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>




        </div>

    </form>


    <div class="row">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">{{$location_title}}</span>
                    </div>


                </div>
                <div class="portlet-body">

                    <table id="data-table"
                           class="table table-striped table-bordered ">
                        <thead>
                        <tr>

                            <th>{{trans('main.support')}}</th>
                            <th>{{trans('reports.total')}}</th>

                        </tr>
                        </thead>

                            <tbody>

                            <tr>
                                <td>{{trans('messages.customers_messages')}}</td>
                                <td>{{$CustomerMessage}}</td>
                            </tr>

                            <tr>
                                <td>{{trans('messages.users_messages')}}</td>
                                <td>{{$restaurantMessage}}</td>
                            </tr>


                                </tbody>

                            <tfoot>
                            <tr>
                                <th >
                                    {{trans('reports.total')}}
                                </th>
                                <th id="total">

                                </th>

                            </tr>
                            </tfoot>

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

    <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
@endpush
@push('js')


    <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
    <script>


        $(document).ready(function() {
            var table = $('#data-table').DataTable( {
                "paging":   false,
                "ordering": false,
                "bFilter": false,
                "info":     false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        footer: true,
                        title: "{{trans('main.support')}} {{trans('reports.from')}} {{$from}} {{trans('reports.to')}} {{$to}}"
                    },
                    { extend: 'excelHtml5', footer: true, title: "payments_methods_{{$from}}_to_{{$to}}" },
                ],
                drawCallback: function () {
                    var api = this.api();
                    $( "#total" ).html(
                        api.column( 1, {page:'current'} ).data().sum()
                    );
                }
            } );


        } );


    </script>
@endpush
