<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <div class="menu-toggler sidebar-toggler">
                <img alt="Logo" height="30px" src="{{url('img/logo.jpg')}}">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>


        <!-- END RESPONSIVE MENU TOGGLER -->
        <div class="top-menu">

            <ul class="nav navbar-nav pull-right">
                @role(['superadmin','c','admin','c2'])

                  <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="true">
                                    <i class="icon-notebook"></i>
                                    <span class="badge badge-default"> {{ count($customer_new_messages) }} </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>
                                            <span class="bold">{{ count($customer_new_messages) }}</span> {{ trans('main.messages') }}</h3>
                                        <a href="{{ url('customers_messages') }}">{{ trans('main.show_all') }}</a>
                                    </li>
                                    <li>
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 275px;"><ul class="dropdown-menu-list scroller" style="height: 275px; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
                                            @foreach($customer_new_messages as $message)
                                                <li>
                                                <a href="{{url('messages/customer_message_details/'.$message->id)}}">

                                                    <span class="subject" style="margin-left: 0px">
                                                        <span class="from" > {{ $message->sender->name }} </span>
                                                        <span class="time">{{ $message->created_at }} </span>
                                                    </span>
                                                    <span class="message" style="margin-left: 0px">{{ $message->title }}</span>
                                                </a>
                                            </li>
                                            @endforeach


                                        </ul><div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 159.211px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                                    </li>
                                </ul>
                            </li>
                @endrole

                @role(['superadmin','c','admin','c1'])
                <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="true">
                                    <i class="icon-envelope-open"></i>
                                    <span class="badge badge-default"> {{ count($new_messages) }} </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>
                                            <span class="bold">{{ count($new_messages) }}</span> {{ trans('main.messages') }}</h3>
                                        @role(['c','cuperadmin','c1'])
                                        <a href="{{ url('users_messages') }}">{{ trans('main.show_all') }}</a>
                                        @endrole
                                        @role(['admin'])
                                        <a href="{{ url('messages/sent') }}">{{ trans('main.show_all') }}</a>
                                        @endrole
                                    </li>
                                    <li>
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 275px;"><ul class="dropdown-menu-list scroller" style="height: 275px; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
                                            @foreach($new_messages as $message)
                                                <li>
                                                <a href="{{url('messages/user_message_details/'.$message->id)}}">

                                                    <span class="subject" style="margin-left: 0px">
                                                        <span class="from" > {{ $message->sender->name }} </span>
                                                        <span class="time">{{ $message->created_at }} </span>
                                                    </span>
                                                    <span class="message" style="margin-left: 0px">{{ $message->title }}</span>
                                                </a>
                                            </li>
                                            @endforeach


                                        </ul><div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 159.211px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                                    </li>
                                </ul>
                            </li>
                @endrole

                @role('admin')
                <li class="dropdown dropdown-user">
                    <a href="{{ url('restaurants/profile') }}" class="dropdown-toggle" >
                        <span class="username username-hide-on-mobile"> {{ trans('restaurants.restaurant_profile') }} </span>
                        <i class="fa fa-cutlery"></i>
                    </a>
                </li>

               @endrole

                <li class="dropdown dropdown-user">
                    <a href="{{ url('users/profile') }}" class="dropdown-toggle" >
                        <span class="username username-hide-on-mobile"> {{ @Auth::user()->name }} </span>
                        <i class="icon-user"></i>
                    </a>
                </li>

                  <li class="dropdown dropdown-language">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                    @if(Auth::user()->language_id=='ar')
                                        <img alt="" src="{{url('')}}/assets/global/img/flags/sa.png">
                                        <span class="langname"> AR </span>
                                        <i class="fa fa-angle-down"></i>
                                        @elseif(Auth::user()->language_id=='tr')
                                        <img alt="" src="{{url('')}}/assets/global/img/flags/tr.png">
                                        <span class="langname"> TR </span>
                                        <i class="fa fa-angle-down"></i>
                                        @else
                                        <img alt="" src="{{url('')}}/assets/global/img/flags/us.png">
                                        <span class="langname"> EN </span>
                                        <i class="fa fa-angle-down"></i>
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('language/ar') }}">
                                              {{__('main.arabic')}}
                                            <img alt="" src="{{url('')}}/assets/global/img/flags/sa.png"></a>
                                    </li>
                                    <li>
                                        <a href="{{ url('language/tr') }}">
                                              {{__('main.turkish')}}
                                            <img alt="" src="{{url('')}}/assets/global/img/flags/tr.png"></a>
                                    </li>
                                    <li>
                                        <a href="{{ url('language/en') }}">
                                              {{__('main.english')}}
                                            <img alt="" src="{{url('')}}/assets/global/img/flags/us.png"></a>
                                    </li>

                                </ul>
                            </li>


                            <li class="dropdown dropdown-extended quick-sidebar-toggler">
                                <a class="dropdown-toggle"  href="{{ route('logout') }}">
                                <i class="icon-logout"></i>
                                </a>
                            </li>
            </ul>
        </div>
    </div>
    <!-- END HEADER INNER -->
</div>
<div class="clearfix"> </div>
