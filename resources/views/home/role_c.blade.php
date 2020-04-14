@extends('layouts.main')

@section('content')

                <div class="row">

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="{{url('customers_messages')}}">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$customer_messages_count}}">0</span></div>
                                <div class="desc">{{trans('messages.customers_messages')}}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="{{url('users_messages')}}">
                            <div class="visual">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$restaurant_messages_count}}">0</span>
                                </div>
                                <div class="desc">{{trans('messages.users_messages')}}</div>
                            </div>
                        </a>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-12 col-sm-12">
                        <!-- BEGIN PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-bar-chart font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase">{{trans('messages.customers_messages')}}</span>
                                    <span class="caption-helper">{{trans('main.last_6_months')}}.</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div id="customer_messages_months_loading">
                                    <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>
                                <div id="customer_messages_months_content" class="display-none">
                                    <div id="customer_messages_months" class="chart"> </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET-->
                    </div>
                    <div class="col-lg-6 col-xs-12 col-sm-12">
                        <!-- BEGIN PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-bar-chart font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase">{{trans('messages.users_messages')}}</span>
                                    <span class="caption-helper">{{trans('main.last_6_months')}}.</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div id="restaurant_messages_months_loading">
                                    <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>
                                <div id="restaurant_messages_months_content" class="display-none">
                                    <div id="restaurant_messages_months" class="chart"> </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET-->
                    </div>
                </div>



@stop

@push('css')
    <style>
        .restaurant {
            right: 8px;
            padding: 10px;
            border-left: 1px solid #F3565D;
        }
        .feeds li .col2 {
            width: 100px;
        }
        .feeds li .col1 {
            width: 90%;
        }
    </style>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
@endpush

@push('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/themes/patterns.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/horizontal-timeline/horizontal-timeline.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <script src="{{url('')}}/assets/pages/scripts/dashboard.js" type="text/javascript"></script>

    <script>
        function showChartTooltip(x, y, xValue, yValue) {
            $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                position: 'absolute',
                display: 'none',
                top: y - 40,
                left: x - 40,
                border: '0px solid #ccc',
                padding: '2px 6px',
                'background-color': '#fff'
            }).appendTo("body").fadeIn(200);
        }

        var restaurant_messages_months = <?php
            echo "[";
            foreach($restaurant_messages_months as $month=>$value){
                echo "['$month',$value],";
            }
            echo "]";
            ?>;

        if ($('#restaurant_messages_months').size() != 0) {

            $('#restaurant_messages_months_loading').hide();
            $('#restaurant_messages_months_content').show();

            var plot_statistics = $.plot($("#restaurant_messages_months"), [{
                    data: restaurant_messages_months,
                    lines: {
                        fill: 0.6,
                        lineWidth: 0
                    },
                    color: ['#f89f9f']
                }, {
                    data: restaurant_messages_months,
                    points: {
                        show: true,
                        fill: true,
                        radius: 5,
                        fillColor: "#f89f9f",
                        lineWidth: 3
                    },
                    color: '#fff',
                    shadowSize: 0
                }],

                {
                    xaxis: {
                        tickLength: 0,
                        tickDecimals: 0,
                        mode: "categories",
                        min: 0,
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    yaxis: {
                        ticks: 5,
                        tickDecimals: 0,
                        tickColor: "#eee",
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eee",
                        borderColor: "#eee",
                        borderWidth: 1
                    }
                });


        }

        $("#restaurant_messages_months").bind("plothover", function(event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + '  ');
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
        /***************************/
        var customer_messages_months = <?php
            echo "[";
            foreach($customer_messages_months as $month=>$value){
                echo "['$month',$value],";
            }
            echo "]";
            ?>;
        if ($('#customer_messages_months').size() != 0) {

            $('#customer_messages_months_loading').hide();
            $('#customer_messages_months_content').show();

            $.plot($("#customer_messages_months"), [{
                    data: customer_messages_months,
                    lines: {
                        fill: 0.6,
                        lineWidth: 0
                    },
                    color: ['#549cf8']
                }, {
                    data: customer_messages_months,
                    points: {
                        show: true,
                        fill: true,
                        radius: 5,
                        fillColor: "#549cf8",
                        lineWidth: 3
                    },
                    color: '#fff',
                    shadowSize: 0
                }],

                {
                    xaxis: {
                        tickLength: 0,
                        tickDecimals: 0,
                        mode: "categories",
                        min: 0,
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    yaxis: {
                        ticks: 5,
                        tickDecimals: 0,
                        tickColor: "#eee",
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eee",
                        borderColor: "#eee",
                        borderWidth: 1
                    }
                });


        }

        $("#customer_messages_months").bind("plothover", function(event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + '  ');
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });




    </script>
@endpush
