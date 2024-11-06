<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                    <span class="pcoded-mtext">Listings</span>
                    <span class="pcoded-badge label label-warning">NEW</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="{{ url('/') }}">
                            <span class="pcoded-mtext">Stocks</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="{{ url('/funds') }}" target="_blank">
                            <span class="pcoded-mtext">Funds</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
