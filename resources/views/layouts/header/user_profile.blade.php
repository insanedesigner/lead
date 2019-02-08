<?php
    $name   =   $userData['first_name']." ".$userData['last_name'];
    $email  =   $userData['email'];
    //$profileImage   =   "../".$userData['path']."/".$userData['bucket_name']."/".$userData['uid']."/".$userData['type']."/".$userData['filename'];
    $profileImage   =   "../public/assets/images/users/2.jpg";
?>
<ul class="navbar-nav my-lg-0">
    <!-- ============================================================== -->
    <!-- Search -->
    <!-- ============================================================== -->
    <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
        <form class="app-search">
            <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
    </li>
    <!-- ============================================================== -->
    <!-- Language -->
    <!-- ============================================================== -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
        <div class="dropdown-menu dropdown-menu-right scale-up"> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> </div>
    </li>
    <!-- ============================================================== -->
    <!-- Profile -->
    <!-- ============================================================== -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{$profileImage}}" alt="user" class="profile-pic" /></a>
        <div class="dropdown-menu dropdown-menu-right scale-up">
            <ul class="dropdown-user">
                <li>
                    <div class="dw-user-box">
                        <div class="u-img"><img src="{{$profileImage}}" alt="user"></div>
                        <div class="u-text">
                            <h4>{{$name}}</h4>
                            <p class="text-muted">{{$email}}</p><a href="pages-profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                    </div>
                </li>
                <li role="separator" class="divider"></li>
                <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="../logout"><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
        </div>
    </li>
</ul>
