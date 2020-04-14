@extends('layouts.main')

@section('content')

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="{{url('products')}}">
                            <div class="visual">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$products}}">0</span>
                                </div>
                                <div class="desc">{{trans('main.products')}}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="{{url('orders')}}">
                            <div class="visual">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$orders}}">0</span>
                                </div>
                                <div class="desc">{{trans('main.orders')}}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 purple" href="{{url('reports/payments')}}">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$payments}}">0</span></div>
                                <div class="desc">{{trans('main.payments')}}</div>
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
                                    <span class="caption-subject font-dark bold uppercase">{{trans('main.orders')}}</span>
                                    <span class="caption-helper">{{trans('main.last_6_months')}}.</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div id="orders_per_month_loading">
                                    <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>
                                <div id="orders_per_month_content" class="display-none">
                                    <div id="orders_per_month" class="chart"> </div>
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
                                    <span class="caption-subject font-dark bold uppercase">{{trans('main.payments')}}</span>
                                    <span class="caption-helper">{{trans('main.last_6_months')}}.</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div id="payments_per_month_loading">
                                    <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>
                                <div id="payments_per_month_content" class="display-none">
                                    <div id="payments_per_month" class="chart"> </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET-->
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-xs-12 col-sm-12">
                        <!-- BEGIN PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-bar-chart font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase">{{trans('reports.credit')}}</span>
                                    <span class="caption-helper">{{trans('main.last_6_months')}}.</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div id="credit_per_month_loading">
                                    <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>
                                <div id="credit_per_month_content" class="display-none">
                                    <div id="credit_per_month" class="chart"> </div>
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
                                    <span class="caption-subject font-dark bold uppercase">{{trans('reports.debit')}}</span>
                                    <span class="caption-helper">{{trans('main.last_6_months')}}.</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div id="debit_per_month_loading">
                                    <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>
                                <div id="debit_per_month_content" class="display-none">
                                    <div id="debit_per_month" class="chart"> </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET-->
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-xs-12 col-sm-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-share font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase">{{trans('main.users_app_reviews')}}</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;">
                                    <div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible="0" data-initialized="1">

                                        <ul class="chats">
                                            @foreach($customer_reviews as $review)
                                                <li class="in">
                                               <span class="avatar" style="width:100px">
                                                     {{$review->user->name}}
                                                    </span>
                                                    <div class="message" style="margin-left:120px">
                                                        <span class="arrow"> </span>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        {{$review->review_rank}}
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc"> {{$review->review_text}} </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date"> {{date('d-m-Y H:i', strtotime($review->created_at)) }} </div>
                                                        </div>
                                                    </div>


                                                </li>
                                            @endforeach


                                        </ul>

                                    </div>
                                </div>
                                <div class="scroller-footer">
                                    <div class="btn-arrow-link pull-right">
                                        <a href="{{url('restaurants/profile')}}">{{trans('main.show_all')}}</a>
                                        <i class="icon-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xs-12 col-sm-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-share font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase">{{trans('restaurants.admin_reviews')}}</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;">
                                    <div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible="0" data-initialized="1">

                                        <ul class="chats">
                                            @foreach($admin_reviews as $review)
                                                <li class="in">
                                               <span class="avatar" style="width:100px">
                                                     {{$review->user->name}}
                                                   <p class="restaurant">
                                                       {{$review->restaurant->name}}
                                                   </p>
                                                    </span>

                                                    <div class="message" style="margin-left:120px">
                                                        <span class="arrow"> </span>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-info">
                                                                        {{$review->review_rank}}
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc"> {{$review->review_text}} </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col2">
                                                            <div class="date"> {{date('d-m-Y H:i', strtotime($review->created_at)) }} </div>
                                                        </div>

                                                    </div>


                                                </li>
                                            @endforeach


                                        </ul>

                                    </div>
                                </div>
                                <div class="scroller-footer">
                                    <div class="btn-arrow-link pull-right">
                                        <a href="{{url('restaurants/profile')}}">{{trans('main.show_all')}}</a>
                                        <i class="icon-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        var orders_per_month = <?php
            echo "[";
            foreach($orders_per_month as $month=>$value){
                echo "['$month',$value],";
            }
            echo "]";
            ?>;

        if ($('#orders_per_month').size() != 0) {

            $('#orders_per_month_loading').hide();
            $('#orders_per_month_content').show();

            var plot_statistics = $.plot($("#orders_per_month"), [{
                    data: orders_per_month,
                    lines: {
                        fill: 0.6,
                        lineWidth: 0
                    },
                    color: ['#f89f9f']
                }, {
                    data: orders_per_month,
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

        $("#orders_per_month").bind("plothover", function(event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' {{trans('main.orders')}} ');
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
        /***************************/
        var payments_per_month = <?php
            echo "[";
            foreach($payments_per_month as $month=>$value){
                echo "['$month',$value],";
            }
            echo "]";
            ?>;
        if ($('#payments_per_month').size() != 0) {

            $('#payments_per_month_loading').hide();
            $('#payments_per_month_content').show();

            $.plot($("#payments_per_month"), [{
                    data: payments_per_month,
                    lines: {
                        fill: 0.6,
                        lineWidth: 0
                    },
                    color: ['#549cf8']
                }, {
                    data: payments_per_month,
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

        $("#payments_per_month").bind("plothover", function(event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' {{trans('main.currency')}} ');
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });

        /***************************/
        var credit_per_month = <?php
            echo "[";
            foreach($credit_per_month as $month=>$value){
                echo "['$month',$value],";
            }
            echo "]";
            ?>;
        if ($('#credit_per_month').size() != 0) {

            $('#credit_per_month_loading').hide();
            $('#credit_per_month_content').show();

            $.plot($("#credit_per_month"), [{
                    data: credit_per_month,
                    lines: {
                        fill: 0.6,
                        lineWidth: 0
                    },
                    color: ['#f86d8c']
                }, {
                    data: credit_per_month,
                    points: {
                        show: true,
                        fill: true,
                        radius: 5,
                        fillColor: "#f83d3c",
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

        $("#credit_per_month").bind("plothover", function(event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' {{trans('main.currency')}} ');
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });



        /***************************/
        var debit_per_month = <?php
            echo "[";
            foreach($debit_per_month as $month=>$value){
                echo "['$month',$value],";
            }
            echo "]";
            ?>;
        if ($('#debit_per_month').size() != 0) {

            $('#debit_per_month_loading').hide();
            $('#debit_per_month_content').show();

            $.plot($("#debit_per_month"), [{
                    data: debit_per_month,
                    lines: {
                        fill: 0.6,
                        lineWidth: 0
                    },
                    color: ['#53f82c']
                }, {
                    data: debit_per_month,
                    points: {
                        show: true,
                        fill: true,
                        radius: 5,
                        fillColor: "#44f88a",
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

        $("#debit_per_month").bind("plothover", function(event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' {{trans('main.currency')}} ');
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });



    </script>
@endpush
