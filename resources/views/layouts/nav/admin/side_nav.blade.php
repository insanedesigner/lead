<style>
    .sidebar-nav > ul > li > a.active {
        background: none !important;
    }
</style>


<div class="scroll-sidebar">
    @include('layouts.nav.side_user_profile')

    <nav class="sidebar-nav">
        <ul id="sidebarnav">
            <li class="nav-devider"></li>

             @foreach($screenData as $val)
                 @if($val['id_user_screen'] == 1)
                    <li @if($urlData == "admin/dashboard") class="active" @endif>
                        <a @if($urlData == "admin/dashboard") class="active" @endif  href="dashboard" >
                            <i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                 @endif
                 @if($val['id_user_screen'] == 2)
                     <li>
                         <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Agency</span></a>
                         <ul aria-expanded="false" class="collapse">
                             @if(in_array(1, json_decode($val['sub_screen'])))
                             <li>
                                 <a  href="add_agency">Add</a>
                             </li>
                             @endif
                             @if(in_array(2, json_decode($val['sub_screen'])))
                             <li >
                                 <a  href="manage_agency">Manage </a>
                             </li>
                             @endif
                         </ul>
                     </li>
                 @endif

                 @if($val['id_user_screen'] == 3)
                     <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Lead Type</span></a>
                         <ul aria-expanded="false" class="collapse">
                             <li>
                                 <a href="add_leadtype">Add</a>
                             </li>
                             <li>
                                 <a href="manage_leadtype">Manage </a>
                             </li>
                         </ul>
                     </li>
                 @endif

                 @if($val['id_user_screen'] == 4)
                     <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Lead</span></a>
                         <ul aria-expanded="false" class="collapse">
                             <li>
                                 <a href="add_lead">Add</a>
                             </li>
                             <li>
                                 <a href="manage_lead">Manage </a>
                             </li>
                         </ul>
                     </li>
                 @endif

                 @if($val['id_user_screen'] == 5)
                     <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Users</span></a>
                         <ul aria-expanded="false" class="collapse">
                             <li>
                                 <a href="add_user">Add</a>
                             </li>
                             <li>
                                 <a href="manage_user">Manage </a>
                             </li>
                         </ul>
                     </li>
                 @endif




            @endforeach



        </ul>
    </nav>



</div>







