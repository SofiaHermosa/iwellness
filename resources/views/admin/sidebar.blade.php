<div class="site-menubar">
    <div class="site-menubar-body scrollable scrollable-inverse scrollable-vertical hoverscorll-disabled is-enabled" style="position: relative;">
        <div class="scrollable-container" style="height: 520.984px;">
          <div class="scrollable-content" style="width: 260px;">
            <ul class="site-menu" data-plugin="menu" style="transform: translate3d(0px, 0px, 0px);">
              <li class="site-menu-category"></li>
              @if(auth()->user()->hasrole('system administrator'))
              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/dashboard')}}">
                        <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
                        <span class="site-menu-title">Dashboard</span>
                </a>
              </li>

              @else
                <li class="site-menu-item">
                  <a class="animsition-link waves-effect waves-classic" href="{{url('res')}}">
                          <i class="site-menu-icon md-home" aria-hidden="true"></i>
                          <span class="site-menu-title">Home</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link waves-effect waves-classic" href="{{url('res/profile')}}">
                          <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
                          <span class="site-menu-title">Dashboard</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link waves-effect waves-classic" href="{{url('res/my-orders')}}">
                        <i class="site-menu-icon md-shopping-cart" aria-hidden="true"></i>
                        <span class="site-menu-title">Orders</span>
                  </a>
                </li> 
              @endif

              @if(!auth()->user()->hasrole('system administrator'))
              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/network')}}">
                        <i class="site-menu-icon md-device-hub" aria-hidden="true"></i>
                        <span class="site-menu-title">Network</span>
                </a>
              </li>

              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/manage-funds')}}">
                  <i class="site-menu-icon md-assignment-returned" aria-hidden="true"></i>
                  <span class="site-menu-title">Manage Funds</span>
                </a>
              </li>
  
              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/diamond/conversion')}}">
                  <i class="site-menu-icon fa-diamond" aria-hidden="true"></i>
                  <span class="site-menu-title">Diamond Conversions</span>
                </a>
              </li>
              @endif
              
              @can('access products')
              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/orders')}}">
                      <i class="site-menu-icon md-shopping-cart" aria-hidden="true"></i>
                      <span class="site-menu-title">Orders</span>
                </a>
              </li> 
              @endcan


              @if(auth()->user()->hasrole('system administrator'))
              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/fund-request')}}">
                  <i class="site-menu-icon md-assignment-returned" aria-hidden="true"></i>
                  <span class="site-menu-title">Fund Request</span>
                </a>
              </li>

              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/sales')}}">
                  <i class="site-menu-icon fa-bar-chart-o" aria-hidden="true"></i>
                  <span class="site-menu-title">Sales Analytics</span>
                </a>
              </li>

              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                        <i class="site-menu-icon fa-diamond" aria-hidden="true"></i>
                        <span class="site-menu-title">Diamond Conversion</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('res/diamond/conversion/items')}}">
                      <span class="site-menu-title">Items</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('res/diamond/conversion/request')}}">
                      <span class="site-menu-title">Requests</span>
                    </a>
                  </li>
                </ul>
              </li>
              @endif

              @can('access products')
              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon md-folder" aria-hidden="true"></i>
                    <span class="site-menu-title">File Management</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  @can('access users')
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('res/users')}}">
                      <span class="site-menu-title">Users</span>
                    </a>
                  </li>
                  @endcan
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('res/products')}}">
                      <span class="site-menu-title">Products</span>
                    </a>
                  </li>
                  <li class="site-menu-item">
                    <a class="animsition-link" href="{{url('res/survey')}}">
                      <span class="site-menu-title">Survey</span>
                    </a>
                  </li>
                </ul>
              </li>
              @endcan
              @if(!auth()->user()->hasanyrole('system administrator'))
              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/survey/'.base64_encode(auth()->user()->id))}}">
                      <i class="site-menu-icon fa-tasks" aria-hidden="true"></i>
                      <span class="site-menu-title">Survey</span>
                </a>
              </li>
              @endif
              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/logs/history')}}">
                      <i class="site-menu-icon wb-order" aria-hidden="true"></i>
                      <span class="site-menu-title">Transaction History</span>
                </a>
              </li>
              @if(!auth()->user()->hasanyrole('system administrator'))
              <li class="site-menu-item">
                <a class="animsition-link waves-effect waves-classic" href="{{url('res/activity/logs')}}">
                      <i class="site-menu-icon md-dns" aria-hidden="true"></i>
                      <span class="site-menu-title">Activity Logs</span>
                </a>
              </li>
              @endif
            </ul>
        </div>
    </div>
</div>
    
<div class="site-menubar-footer">
  <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip" data-original-title="Settings">
    <span class="icon md-settings" aria-hidden="true"></span>
  </a>
  <a href="javascript:void(0)" class="share--btn" data-placement="top" data-toggle="tooltip" data-original-title="Share">
    <span class="icon md-share" aria-hidden="true"></span>
  </a>
  <a href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form-side').submit();" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
    <span class="icon md-power" aria-hidden="true"></span>
  </a>

  <form id="logout-form-side" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
  </form>
</div>
</div>

    <div class="site-gridmenu scrollable scrollable-inverse scrollable-vertical is-disabled">
  
    <div class="scrollable-bar scrollable-bar-vertical scrollable-bar-hide is-disabled" draggable="false">
    <div class="scrollable-bar-handle">
</div></div></div>