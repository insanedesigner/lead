<?php

$name           =   $userData['first_name']." ".$userData['last_name'];
//$profileImage   =   "../".$userData['path']."/".$userData['bucket_name']."/".$userData['uid']."/".$userData['type']."/".$userData['filename'];
$profileImage   =   "../public/assets/images/users/2.jpg";

?>
<div class="user-profile">
    <!-- User profile image -->
    <div class="profile-img"> <img src="{{$profileImage}}" alt="user" />
        <!-- this is blinking heartbit-->
        <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
    </div>
    <!-- User profile text-->
    <div class="profile-text">
        <h5>{{$name}}</h5>

    </div>
</div>
