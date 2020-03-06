<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item start {{ @$menu == 'home' ? 'active open' : '' }}">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="title">{{trans('main.home')}}</span>
                    <span class="selected"></span>
                </a>
            </li>
            @permission('users-manage')

                    <li class="nav-item {{ (@$selected == 'users') ? 'active open' : '' }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-user"></i>
                            <span class="title">{{trans('main.users')}}</span>
                            <span class="arrow {{ (@$selected == 'users') ? 'open' : '' }}"></span>
                        </a>
                        <ul class="sub-menu" style="display: {{ (@$selected == 'users') ? 'block' : 'none' }}">
                            <li class="nav-item {{ (@$sub_menu == 'Display-user') ? 'active open' : '' }}">

                                <a href="{{ url('users') }}" class="nav-link">
                                    <i class="fa fa-eye"></i>
                                    <span class="title">{{trans('main.users')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>

           @endpermission

            @role('superadmin')
           <li class="nav-item {{ (@$menu == 'system') ? 'open active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-file"></i>
                    <span class="title">{{trans('main.system')}}</span>
                    <span class="arrow {{ (@$selected == 'system') ? 'open' : '' }}"></span>
                </a>
                <ul class="sub-menu">



                    <li class="nav-item {{ (@$sub_menu == 'lookup') ? 'open active' : '' }} ">
                        <a href="{{ url('lookup') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.lookup')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    
                    
                    <li class="nav-item {{ (@$sub_menu == 'roles') ? 'open active' : '' }} ">
                        <a href="{{ url('roles') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.roles')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ (@$sub_menu == 'permissions') ? 'open active' : '' }} ">
                        <a href="{{ url('permissions') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.permissions')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                   

                </ul>
            </li>
            
            
            <li class="nav-item {{ (@$menu == 'restaurant') ? 'open active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">{{trans('main.restaurants')}}</span>
                    <span class="arrow {{ (@$selected == 'restaurant') ? 'open' : '' }}"></span>
                </a>
                <ul class="sub-menu">



                    <li class="nav-item {{ (@$sub_menu == 'register-restaurants') ? 'open active' : '' }} ">
                        <a href="{{ url('registered-restaurants') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.registered_restaurants')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ (@$sub_menu == 'Display-restaurants') ? 'open active' : '' }} ">
                        <a href="{{ url('restaurants') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.restaurants')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>
            

            @endrole

            @permission('catalog-manage')
            <li class="nav-item {{ (@$menu == 'catalog') ? 'open active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-tag"></i>
                    <span class="title">{{trans('main.catalog')}}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ (@$sub_menu == 'category') ? 'open active' : '' }} ">
                        <a href="{{ url('categories') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.categories')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ (@$sub_menu == 'product') ? 'open active' : '' }} ">
                        <a href="{{ url('products') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.products')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>
            @endpermission

            @permission('orders-manage')
            <li class="nav-item {{ (@$menu == 'sales') ? 'open active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-shopping-cart fw"></i>
                    <span class="title">{{trans('main.sales')}}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ (@$sub_menu == 'orders') ? 'open active' : '' }} ">
                        <a href="{{ url('orders') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.orders')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>
            
            @endpermission
           

            <li class="nav-item {{ (@$menu == 'messages') ? 'open active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-envelope-open"></i>
                    <span class="title">{{trans('main.messages')}}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item {{ (@$sub_menu == 'create-message') ? 'open active' : '' }} ">
                        <a href="{{ url('messages/create') }}" class="nav-link">
                            <i class="fa fa-edit"></i>
                            <span class="title">{{trans('messages.create_message')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    
                    @role('superadmin')
                     <li class="nav-item {{ (@$sub_menu == 'customer_messages') ? 'open active' : '' }} ">
                        <a href="{{ url('customer_messages') }}" class="nav-link">
                            <i class="fa fa-edit"></i>
                            <span class="title">{{trans('messages.customer_messages')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    @endrole
                    
                    <li class="nav-item {{ (@$sub_menu == 'inbox-messages') ? 'open active' : '' }} ">
                        <a href="{{ url('messages/inbox') }}" class="nav-link">
                            <i class="fa fa-edit"></i>
                            <span class="title">{{trans('messages.inbox')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ (@$sub_menu == 'sent-messages') ? 'open active' : '' }} ">
                        <a href="{{ url('messages/sent') }}" class="nav-link">
                            <i class="fa fa-edit"></i>
                            <span class="title">{{trans('messages.sent')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>
            
            <li class="nav-item {{ (@$menu == 'reviews') ? 'open active' : '' }}">
                    <li class="nav-item {{ (@$sub_menu == 'app_review') ? 'open active' : '' }} ">
                        <a href="{{ url('home/app_review') }}" class="nav-link">
                            <i class="fa fa-balance-scale"></i>
                            <span class="title">{{trans('main.app_review')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

            </li>
            

            <li class="nav-item start ">
                <a href="{{ route('logout') }}" class="nav-link">
                    <i class="fa fa-sign-out"></i>
                    <span class="title">{{trans('main.logout')}}</span>
                    <span class="selected"></span>
                </a>
            </li>

        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
