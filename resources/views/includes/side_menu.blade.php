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
            @role(['superadmin','b','admin','c','d'])

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

           @endrole

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

                    <li class="nav-item {{ (@$sub_menu == 'translations') ? 'open active' : '' }} ">
                        <a href="{{ url('translations') }}" target="_blank" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.translations')}}</span>
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

                    <!--<li class="nav-item {{ (@$sub_menu == 'permissions') ? 'open active' : '' }} ">
                        <a href="{{ url('permissions') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.permissions')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>-->

                    <li class="nav-item {{ (@$sub_menu == 'payment_methods') ? 'open active' : '' }} ">
                        <a href="{{ url('payment_methods') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('main.payment_methods')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>



                </ul>
            </li>

            @endrole

            @role(['a','superadmin'])
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

                    <li class="nav-item {{ (@$menu == 'reviews') ? 'open active' : '' }}">
                    <li class="nav-item {{ (@$sub_menu == 'app_review') ? 'open active' : '' }} ">
                        <a href="{{ url('restaurants/reviews') }}" class="nav-link">
                            <i class="fa fa-balance-scale"></i>
                            <span class="title">{{trans('main.restaurant_reviews')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>
            @endrole

            @role(['admin'])
            <li class="nav-item {{ (@$menu == 'restaurants') ? 'open active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">{{trans('main.restaurants')}}</span>
                    <span class="arrow {{ (@$selected == 'restaurant') ? 'open' : '' }}"></span>
                </a>
                <ul class="sub-menu">



                    <li class="nav-item {{ (@$sub_menu == 'restaurant_profile') ? 'open active' : '' }} ">
                        <a href="{{ url('restaurants/profile') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('restaurants.restaurant_profile')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <li class="nav-item {{ (@$sub_menu == 'branches') ? 'open active' : '' }} ">
                        <a href="{{ url('restaurants/profile/branches') }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{trans('restaurants.branches')}}</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                </ul>
            </li>
            @endrole

            @role(['admin','superadmin'])
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
            @endrole

            @role(['superadmin','admin'])
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

            @endrole

            @role(['superadmin','admin','c','b','d'])
            <li class="nav-item {{ (@$menu == 'reports') ? 'open active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-bar-chart"></i>
                    <span class="title">{{trans('main.reports')}}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">

                    @role(['superadmin'])
                    <li class="nav-item {{ (@$sub_menu == 'statistics') ? 'open active' : '' }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-bar-chart"></i>
                            <span class="title">{{trans('main.statistics')}}</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item {{ (@$location == 'restaurants') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/restaurants_statistics') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.restaurants')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                            <li class="nav-item {{ (@$location == 'customers') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/customers_statistics') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.customers')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                            <li class="nav-item {{ (@$location == 'users') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/users_statistics') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.users')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        </ul>

                    </li>
                    @endrole


                    @role(['superadmin','c'])
                    <li class="nav-item {{ (@$sub_menu == 'support') ? 'open active' : '' }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-notebook"></i>
                            <span class="title">{{trans('main.support')}}</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item {{ (@$location == 'support') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/support') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.support')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>



                        </ul>
                    </li>
                    @endrole



                    @role(['superadmin','admin','b'])
                    <li class="nav-item {{ (@$sub_menu == 'orders') ? 'open active' : '' }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-shopping-cart fw"></i>
                            <span class="title">{{trans('main.orders')}}</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            @role(['superadmin','admin'])
                            <li class="nav-item {{ (@$location == 'orders') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/orders') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.orders')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            @endrole
                            @role(['superadmin','admin','b'])
                            <li class="nav-item {{ (@$location == 'most_orders') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/most_orders') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.most_orders')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                            <li class="nav-item {{ (@$location == 'most_ranked') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/most_ranked') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.most_ranked')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            @endrole

                        </ul>
                    </li>

                    @endrole

                    @if(\Entrust::hasRole(['superadmin','d']) ||
                                (\Entrust::hasRole(['admin']) && $user->restaurant->branch_of==null) )

                    <li class="nav-item {{ (@$sub_menu == 'payments') ? 'open active' : '' }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-credit-card"></i>
                            <span class="title">{{trans('main.payments')}}</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item {{ (@$location == 'payments') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/payments') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.payments')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                            <li class="nav-item {{ (@$location == 'payments_methods') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/payments_methods') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.payment_methods')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                            <li class="nav-item {{ (@$location == 'payments_geo') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/payments_geo') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.payments_geo')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item {{ (@$sub_menu == 'financial') ? 'open active' : '' }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-credit-card"></i>
                            <span class="title">{{trans('main.financial')}}</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item {{ (@$location == 'financial') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/financial') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.financial')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                            @role(['superadmin','d'])
                            <li class="nav-item {{ (@$location == 'financial_paid') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/financial_paid') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.financial_paid')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                            <li class="nav-item {{ (@$location == 'financial_not_paid') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/financial_not_paid') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.financial_not_paid')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>


                            @endrole

                            <li class="nav-item {{ (@$location == 'financial_bills') ? 'open active' : '' }} ">
                                <a href="{{ url('reports/financial_bills') }}" class="nav-link">
                                    <i class="fa fa-print"></i>
                                    <span class="title">{{trans('main.financial_bills')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>


                        </ul>
                    </li>

                        @endif
                </ul>
            </li>

            @endrole

            @role(['superadmin','admin','c','c2','c1'])
            @if(!session()->get('acting_as'))
                <li class="nav-item {{ (@$menu == 'support') ? 'open active' : '' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-notebook"></i>
                        <span class="title">{{trans('main.support')}}</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @role(['superadmin','c','c1'])
                        <li class="nav-item {{ (@$sub_menu == 'users_messages') ? 'open active' : '' }} ">
                            <a href="{{ url('users_messages') }}" class="nav-link">
                                <i class="fa fa-edit"></i>
                                <span class="title">{{trans('messages.users_messages')}}</span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        @endrole

                        @role(['superadmin','admin','c','c2'])
                        <li class="nav-item {{ (@$sub_menu == 'customers_messages') ? 'open active' : '' }} ">
                            <a href="{{ url('customers_messages') }}" class="nav-link">
                                <i class="fa fa-edit"></i>
                                <span class="title">{{trans('messages.customers_messages')}}</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        @endrole

                        <?php if (\Entrust::hasRole(['admin'])) : ?>

                        <li class="nav-item {{ (@$sub_menu == 'create-message') ? 'open active' : '' }} ">
                            <a href="{{ url('messages/create') }}" class="nav-link">
                                <i class="fa fa-edit"></i>
                                <span class="title">{{trans('messages.create_message')}}</span>
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
                        <?php endif; ?>


                    </ul>
                </li>
            @endif
            @endrole







            <li class="nav-item {{ (@$menu == 'reviews') ? 'open active' : '' }}">
                    <li class="nav-item {{ (@$sub_menu == 'app_review') ? 'open active' : '' }} ">
                        <a href="{{ url('home/app_review') }}" class="nav-link">
                            <i class="fa fa-balance-scale"></i>
                            <span class="title">{{trans('main.app_review')}}</span>
                            <span class="selected"></span>
                        </a>
             </li>



            @role(['superadmin','b'])
            <li class="nav-item {{ (@$menu == 'users_app_reviews') ? 'open active' : '' }}">
            <li class="nav-item {{ (@$sub_menu == 'users_app_reviews') ? 'open active' : '' }} ">
                <a href="{{ url('users/users_app_reviews') }}" class="nav-link">
                    <i class="fa fa-balance-scale"></i>
                    <span class="title">{{trans('main.users_app_reviews')}}</span>
                    <span class="selected"></span>
                </a>
            </li>
            @endrole

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
