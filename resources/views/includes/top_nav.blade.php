<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <div class="menu-toggler sidebar-toggler">
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
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                        <span class="username username-hide-on-mobile"> {{ @Auth::user()->name }} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="{{ url('users/profile') }}">
                                <i class="icon-user"></i>My profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="icon-key"></i>Logout</a>
                        </li>
                    </ul>
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
                            
            </ul>
        </div>
    </div>
    <!-- END HEADER INNER -->
</div>
<div class="clearfix"> </div>