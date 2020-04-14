@extends('layouts.main')

@section('content')

                <div class="row">

                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="{{url('restaurants')}}">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$restaurants}}">0</span></div>
                                <div class="desc">{{trans('main.restaurants')}}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="{{url('registered-restaurants')}}">
                            <div class="visual">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$new_restaurants}}">0</span>
                                </div>
                                <div class="desc">{{trans('main.registered_restaurants')}}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 purple" href="{{url('restaurants/reviews')}}">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$restaurant_reviews_count}}">0</span></div>
                                <div class="desc">{{trans('main.restaurant_reviews')}}</div>
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
                                    <span class="caption-subject font-dark bold uppercase">{{trans('main.registered_restaurants')}}</span>
                                    <span class="caption-helper">{{trans('main.last_6_months')}}.</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div id="restaurants_per_month_loading">
                                    <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>
                                <div id="restaurants_per_month_content" class="display-none">
                                    <div id="restaurants_per_month" class="chart"> </div>
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
                                    <span class="caption-subject font-dark bold uppercase">{{trans('main.restaurant_reviews')}}</span>
                                    <span class="caption-helper">{{trans('main.last_6_months')}}.</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div id="reviews_per_month_loading">
                                    <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>
                                <div id="reviews_per_month_content" class="display-none">
                                    <div id="reviews_per_month" class="chart"> </div>
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
                                    <span class="caption-subject font-dark bold uppercase">{{trans('main.registered_restaurants')}}</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;">
                                    <div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible="0" data-initialized="1">
                                        <ul class="feeds">
                                            @foreach($restaurants_registrations as $restaurant)
                                                <li>
                                                    <div class="col1">
                                                        <div class="cont">

                                                            <div class="cont-col2">
                                                                <div class="desc">
                                                                    <a href="{{url('registered-restaurant/'.$restaurant->id)}}" >
                                                                    {{$restaurant->name}}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> {{date('d-m-Y', strtotime($restaurant->created_at)) }} </div>
                                                    </div>
                                                </li>

                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                                <div class="scroller-footer">
                                    <div class="btn-arrow-link pull-right">
                                        <a href="{{url('registered-restaurants')}}">{{trans('main.show_all')}}</a>
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
                                    <span class="caption-subject font-dark bold uppercase">{{trans('main.restaurant_reviews')}}</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;">
                                    <div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible="0" data-initialized="1">

                                        <ul class="chats">
                                            @foreach($restaurant_reviews as $review)
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
                                        <a href="{{url('restaurants/reviews')}}">{{trans('main.show_all')}}</a>
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

        var restaurants_per_month = <?php
            echo "[";
            foreach($restaurants_per_month as $month=>$value){
                echo "['$month',$value],";
            }
            echo "]";
            ?>;

        if ($('#restaurants_per_month').size() != 0) {

            $('#restaurants_per_month_loading').hide();
            $('#restaurants_per_month_content').show();

            var plot_statistics = $.plot($("#restaurants_per_month"), [{
                    data: restaurants_per_month,
                    lines: {
                        fill: 0.6,
                        lineWidth: 0
                    },
                    color: ['#f89f9f']
                }, {
                    data: restaurants_per_month,
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

        $("#restaurants_per_month").bind("plothover", function(event, pos, item) {
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
        var reviews_per_month = <?php
            echo "[";
            foreach($reviews_per_month as $month=>$value){
                echo "['$month',$value],";
            }
            echo "]";
            ?>;
        if ($('#reviews_per_month').size() != 0) {

            $('#reviews_per_month_loading').hide();
            $('#reviews_per_month_content').show();

            $.plot($("#reviews_per_month"), [{
                    data: reviews_per_month,
                    lines: {
                        fill: 0.6,
                        lineWidth: 0
                    },
                    color: ['#549cf8']
                }, {
                    data: reviews_per_month,
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

        $("#reviews_per_month").bind("plothover", function(event, pos, item) {
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
