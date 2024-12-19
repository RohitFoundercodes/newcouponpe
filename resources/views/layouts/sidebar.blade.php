
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('dashboard')}}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
   
                 {{--      <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">System User </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                               @php
                                    $roles = App\Models\Role::all();
                                @endphp
                                @foreach($roles as $item)
                                <li class="sidebar-item"><a href="authentication-login.html" class="sidebar-link"><i class="mdi mdi-all-inclusive"></i><span class="hide-menu">{{ $item->name}} </span></a></li>
                                @endforeach
                              
                            </ul>
                        </li> --}}
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('player.index')}}" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Users</span></a></li>
                        
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('banner.index')}}" aria-expanded="false"><i class="mdi mdi-relative-scale"></i><span class="hide-menu">Banner</span></a></li>
                        
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('order.index')}}" aria-expanded="false"><i class="mdi mdi-relative-scale"></i><span class="hide-menu">Order Place</span></a></li>
                        
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('payin.index')}}" aria-expanded="false"><i class="mdi mdi-relative-scale"></i><span class="hide-menu">payin</span></a></li>
                        
                        
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-cogs"></i><span class="hide-menu">Settings</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="" class="sidebar-link"><i class="fas fa-bell"></i><span class="hide-menu"> Notification </span></a></li>
                                <li class="sidebar-item"><a href="" class="sidebar-link"><i class="fas fa-question-circle"></i><span class="hide-menu"> Support </span></a></li>
                                <li class="sidebar-item"><a href="{{ route('site.content', ['slug' => 'privacy-policy']) }}" class="sidebar-link"><i class="fas fa-lock"></i><span class="hide-menu"> Privacy Policy </span></a></li>
                                <li class="sidebar-item"><a href="{{ route('site.content', ['slug' => 'terms-and-conditions']) }}" class="sidebar-link"><i class="fas fa-gavel"></i><span class="hide-menu"> Terms & Conditions </span></a></li>
                                <li class="sidebar-item"><a href="{{ route('site.content', ['slug' => 'about-us']) }}" class="sidebar-link"><i class="fas fa-info-circle"></i><span class="hide-menu"> About Us </span></a></li>
                            </ul>
                        </li>
                        
                           <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('roles.index')}}" aria-expanded="false"><i class="mdi mdi-relative-scale"></i><span class="hide-menu">Role</span></a></li>-->
                      
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
     
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
             
           
 