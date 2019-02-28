<style>
    .sidebar-nav > ul > li > a.active {
        background: none !important;
    }
</style>







<?php



    $dashboard      =   "";
    $addAgency      =   "";
    $manageAgency   =   "";




switch($idScreen){
    case 1:
        $dashboard    =   "active";
        break;
    case 2:
        $addAgency      =   "active";
        break;
    case 3:
        $manageAgency     =   "active";
        break;

    case 4:
        $addStreamActive     =   "active";
        break;
    case 5:
        $viewStreamActive     =   "active";
        break;
    case 6:
        $addCoursesCatActive   =    "active";
        break;
    case 7:
        $viewCoursesCatActive  =    "active";
        break;
    case 8:
        $addCoursesActive  =    "active";
        break;
    case 9:
        $viewCoursesActive  =    "active";
        break;
    case 10:
        $addUniversityActive  =    "active";
        break;
    case 11:
        $viewUniversityActive  =    "active";
        break;
    case 12:
        $mediaUniversityActive  =    "active";
    case 14:
        $addCoursesToUniversityActive   =   "active";
        break;




    default:

}





   /* if($idRole  ==  1){
        if(!empty($urlData)){
            //$idScreen   =   $urlData['id_user_screen'];

            switch($idScreen){
                case 1:
                    $dashboardActive    =   "active";
                    break;
                case 2:
                    $addroleActive      =   "active";
                    break;
                case 3:
                    $viewroleActive     =   "active";
                    break;

                case 4:
                    $addStreamActive     =   "active";
                    break;
                case 5:
                    $viewStreamActive     =   "active";
                    break;
                case 6:
                    $addCoursesCatActive   =    "active";
                    break;
                case 7:
                    $viewCoursesCatActive  =    "active";
                    break;
                case 8:
                    $addCoursesActive  =    "active";
                    break;
                case 9:
                    $viewCoursesActive  =    "active";
                    break;
                case 10:
                    $addUniversityActive  =    "active";
                    break;
                case 11:
                    $viewUniversityActive  =    "active";
                    break;
                case 12:
                    $mediaUniversityActive  =    "active";
                case 14:
                    $addCoursesToUniversityActive   =   "active";
                    break;




                default:

            }
        }

    }*/



?>

<!-- Sidebar scroll-->
<div class="scroll-sidebar">
    <!-- User profile -->
    @include('layouts.nav.side_user_profile')
    <!-- End User profile text-->
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
        <ul id="sidebarnav">
            <li class="nav-devider"></li>

            @foreach($screenData as $val)
                @if($val['id_user_screen'] == 1)
                    <li class="{{$dashboard}}">
                        <a class="{{$dashboard}}" href="dashboard" >
                            <i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                @endif

                @if($val['id_user_screen'] == 2 && !empty($val['sub_screen']))
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Agency</span></a>
                        <ul aria-expanded="false" class="collapse">

                            @if(in_array(1, json_decode($val['sub_screen'])))
                                <li class="{{$addAgency }}"><a class="{{$addAgency}}" href="add_agency">Add</a></li>
                            @endif
                            @if(in_array(2, json_decode($val['sub_screen'])))
                                <li class="{{$manageAgency}}"><a class="{{$manageAgency}}" href="manage_agency">Manage </a></li>
                            @elseif(in_array(3, json_decode($val['sub_screen'])))
                                <li class="{{$manageAgency}}"><a class="{{$manageAgency}}" href="manage_agency">Manage </a></li>
                            @elseif(in_array(4, json_decode($val['sub_screen'])))
                                <li class="{{$manageAgency}}"><a class="{{$manageAgency}}" href="manage_agency">Manage </a></li>s
                            @endif

                        </ul>
                    </li>
                @endif
            @endforeach


        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->
