<!-- end:: Aside -->

<!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav ">
                <li class="kt-menu__item dashboard-menu" aria-haspopup="true">
                    <a href="{{ route('admin.dashboard') }}" class="kt-menu__link ">
                        <i class="kt-menu__link-icon flaticon-home"></i>
                        <span class="kt-menu__link-text">Dashboard</span>
                    </a>
                </li>

                <li class="kt-menu__item customer-menu" aria-haspopup="true">
                    <a href="{{ route('admin.customers.index') }}" class="kt-menu__link ">
                        <i class="kt-menu__link-icon flaticon-users"></i>
                        <span class="kt-menu__link-text">Customers</span>
                    </a>
                </li>

                <li class="kt-menu__item vendor-menu" aria-haspopup="true">
                    <a href="{{ route('admin.vendors.index') }}" class="kt-menu__link ">
                        <i class="kt-menu__link-icon flaticon-users"></i>
                        <span class="kt-menu__link-text">Vendors</span>
                    </a>
                </li>

                <li class="kt-menu__item chat-menu" aria-haspopup="true">
                    <a href="{{ route('admin.chats.index') }}" class="kt-menu__link ">
                        <i class="kt-menu__link-icon flaticon-chat-1"></i>
                        <span class="kt-menu__link-text">Chats</span>
                    </a>
                </li>

                <li class="kt-menu__section ">
                    <h4 class="kt-menu__section-text">Features</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i>
                </li>

                <li class="kt-menu__item  kt-menu__item--submenu booking-menu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                        <i class="kt-menu__link-icon flaticon2-crisp-icons-1"></i>
                        <span class="kt-menu__link-text">Bookings</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                                <span class="kt-menu__link">
                                    <span class="kt-menu__link-text">Bookings</span>
                                </span>
                            </li>
                            <li class="kt-menu__item booking-pending-menu" aria-haspopup="true">
                                <a href="{{ route('admin.bookings.pendingBooking') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"></i>
                                    <span class="kt-menu__link-text">Pending</span>
                                </a>
                            </li>
                            <li class="kt-menu__item booking-live-menu" aria-haspopup="true">
                                <a href="{{ route('admin.bookings.liveBooking') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"></i>
                                    <span class="kt-menu__link-text">Live</span>
                                </a>
                            </li>
                            <li class="kt-menu__item booking-confirm-menu" aria-haspopup="true">
                                <a href="{{ route('admin.bookings.confirmedBooking') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"></i>
                                    <span class="kt-menu__link-text">Confirmed</span>
                                </a>
                            </li>
                            <li class="kt-menu__item booking-completed-menu" aria-haspopup="true">
                                <a href="{{ route('admin.bookings.completedBooking') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"></i>
                                    <span class="kt-menu__link-text">Completed</span>
                                </a>
                            </li>
                            <li class="kt-menu__item booking-expired-menu" aria-haspopup="true">
                                <a href="{{ route('admin.bookings.expiredBooking') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"></i>
                                    <span class="kt-menu__link-text">Expired</span>
                                </a>
                            </li>
                            <li class="kt-menu__item booking-cancel-menu" aria-haspopup="true">
                                <a href="{{ route('admin.bookings.cancelBooking') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"></i>
                                    <span class="kt-menu__link-text">Cancel</span>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <li class="kt-menu__item  kt-menu__item--submenu master-menu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                        <i class="kt-menu__link-icon flaticon-layers"></i>
                        <span class="kt-menu__link-text">Masters</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                                <span class="kt-menu__link">
                                    <span class="kt-menu__link-text">Masters</span>
                                </span>
                            </li>
                            <li class="kt-menu__item vehicle-type-menu" aria-haspopup="true">
                                <a href="{{ route('admin.vehicleTypes.index') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                    <span class="kt-menu__link-text">Type Of Vehicles</span>
                                </a>
                            </li>
                            <li class="kt-menu__item cargotype-menu" aria-haspopup="true">
                                <a href="{{ route('admin.cargoTypes.index') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                    <span class="kt-menu__link-text">Type Of Cargo</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="kt-menu__item promotion-menu" aria-haspopup="true">
                    <a href="{{ route('admin.promotionImages.index') }}" class="kt-menu__link ">
                        <i class="kt-menu__link-icon flaticon2-photograph"></i>
                        <span class="kt-menu__link-text">Promotion Images</span>
                    </a>
                </li>
                <li class="kt-menu__item notification-menu" aria-haspopup="true">
                    <a href="{{ route('admin.appNotifications.index') }}" class="kt-menu__link ">
                        <i class="kt-menu__link-icon flaticon-alarm"></i>
                        <span class="kt-menu__link-text">Notifications</span>
                    </a>
                </li>
                <li class="kt-menu__item " aria-haspopup="true">
                    <a href="{{ route('admin.pages.index') }}" class="kt-menu__link ">
                        <i class="kt-menu__link-icon flaticon-file-1"></i>
                        <span class="kt-menu__link-text">Pages</span>
                    </a>
                </li>

                <li class="kt-menu__item  kt-menu__item--submenu config-menu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                        <i class="kt-menu__link-icon flaticon-settings-1"></i>
                        <span class="kt-menu__link-text">Configurations</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item  kt-menu__item--parent " aria-haspopup="true">
                                <span class="kt-menu__link">
                                    <span class="kt-menu__link-text">Configurations</span>
                                </span>
                            </li>
                            <li class="kt-menu__item pushconfig-menu " aria-haspopup="true">
                                <a href="{{ route('config.push') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                    <span class="kt-menu__link-text">Push Config.</span>
                                </a>
                            </li>
                            <li class="kt-menu__item send-push-menu" aria-haspopup="true">
                                <a href="{{ route('config.send_create') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                    <span class="kt-menu__link-text">Send Push</span>
                                </a>
                            </li>
                            <li class="kt-menu__item trans-menu" aria-haspopup="true">
                                <a href="{{ route('config.translation') }}" class="kt-menu__link ">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                    <span class="kt-menu__link-text">Comments</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="kt-menu__item query-menu" aria-haspopup="true">
                    <a href="{{ route('admin.contactUs.index') }}" class="kt-menu__link ">
                        <i class="kt-menu__link-icon flaticon-chat-1"></i>
                        <span class="kt-menu__link-text">Queries</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

<!-- end:: Aside Menu -->
</div>
