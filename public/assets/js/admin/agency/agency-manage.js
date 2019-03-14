
$(function() {
    "use strict";



    var runUniversityDetails = function() {
        $(document).ready(function() {
            var fullTable       = $('#full_table').DataTable( { responsive: true } );
            var activeTable     = $('#active_table');
            activeTable.DataTable( {
                responsive: true,
                "fnDrawCallback": function( oSettings ) {
                    $('.active_btn, .inactive_btn').click(function(e){
                        e.preventDefault();

                        var idAgency    =   $(this).attr('data-value');
                        var status      =   $(this).attr('data-text');
                        var dataString  =   'id='+idAgency+'&status='+status;

                        swal({
                            title: "Are you sure?",
                            text: "",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes",
                            closeOnConfirm: false
                        }, function(){
                            $.ajax({
                                type: 'POST',
                                url: "../api/handleAgencyStatusChange",
                                data:   dataString,
                                dataType: "JSON",
                                cache: false,

                                success: function (data) {
                                    if(data == 'success'){
                                        swal({
                                                title: "Bingo",
                                                text: "Your status has been updated.",
                                                type: "success"
                                            },
                                            function(){
                                                window.location.href = 'manage_agency';
                                            });
                                    }


                                }
                            });
                        })





                    })




                },

            } );
            var inactiveTable   = $('#inactive_table').DataTable( { responsive: true } );


        } );
    }

    var editButtonClick =   function(){
        $('.edit_btn').click(function(e){
            e.preventDefault();

            $('#id_agency').val($(this).attr('data-value'));
            $('#editAgencyForm').submit();
        })
    };

   var runUserAddBtn    =   function(){
       $('.add_user_btn').click(function(e){
            e.preventDefault();

            $('.check_email').show();
            $('.map_btn').hide();
            $('.add_user').hide();


           $('.email').val('');

            var id  =   $(this).attr('data-value');

            $('#add_user'+id).modal('show');
       });
   };

   var runCheckEmail    =   function(){
       $('.check_email').click(function(e){
           e.preventDefault();




           var idAgency =   $(this).attr('data-value');
           var email    =   $('#email'+idAgency).val();
           var dataString   =   'email='+email;

           $.ajax({
               type: 'POST',
               url: "../api/handleEmailCheck",
               dataType: "JSON",
               data: dataString,
               cache: false,

               success: function (data) {

                   $('.sub_btn_div').remove();

                   if(data!=""){
                       if(data['status']=="user_exist"){
                           var msgString    =
                               '<div class="msg_sub_div">'+
                               '<div class="alert alert-warning">' +
                               '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>'+
                               '<p style="padding-left:-5px">'+email+' already exists.</p>'+
                               '</div>'+
                               '</div>';

                           $('.msg_div').append(msgString);


                           var btnString    =
                               '<div class="sub_btn_div">' +
                               '<button data-value ="'+idAgency+'" class="btn waves-effect btn-info btn-outline-warning map_btn"><span style="font-size: 12px">Map User to Agency</span></button>'+
                                '</div>';

                           $('.main_btn_div').append(btnString);

                           $('.add_user_main_div').hide();

                           $('.check_email').hide();
                           $('.map_btn').show();



                           runMapBtn(idAgency, email);
                           runEmailText(idAgency);
                       }
                       if(data['status'] == "user_empty"){
                           var msgString2    =
                               '<div class="msg_sub_div">'+
                               '<div class="alert alert-success">' +
                               '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>'+
                               '<p style="padding-left:-5px">No user exists with '+email+'.</p>'+
                               '</div>'+
                               '</div>';

                           $('.msg_div').append(msgString2);

                           var string    =
                               '<div class="sub_btn_div">' +
                               '<button data-value = "'+idAgency+'" class="btn waves-effect btn-info btn-outline-success add_user"><span style="font-size: 12px">Add User</span></button>'+
                               '</div>';

                           $('.main_btn_div').append(string);

                           $('.add_user_main_div').show();
                           $('.check_email').hide();
                           $('.add_user').show();




                           runAddUser(idAgency, email);
                           runEmailText(idAgency);

                       }
                       else if(data['status'] == "invalid_email"){
                           var msgString    =
                               '<div class="msg_sub_div">'+
                               '<div class="alert alert-danger">' +
                               '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>'+
                               '<p style="padding-left:-5px">Invalid Email.</p>'+
                               '</div>'+
                               '</div>';

                           $('.msg_div').append(msgString);

                           $('.add_user_main_div').hide();

                       }
                   }

               }
           });

           runEmailText();
       });
   }

   var runMapBtn    =   function(idAgency, email){
       $('.map_btn').click(function(e){
           e.preventDefault();

           /*var idAgency     =   $(this).attr('data-value');
           var userEmail    =   $('#email'+idAgency).val();*/
           var dataString   =   'id_agency='+idAgency+'&email='+email;


           if(email!=''){
               $.ajax({
                   type: 'POST',
                   url: "../api/mapUserAgency",
                   dataType: "JSON",
                   data: dataString,
                   cache: false,

                   success: function (data) {
                        if(data!=''){

                            if(data['status']=='success'){
                                swal({
                                    icon: data['status'],
                                    text: data['msg']+' Please use the credentials for login, Username: '+data['username']+', Password: '+data['password'],
                                    title:''
                                });
                            }
                            else{
                                swal({
                                    icon: data['status'],
                                    text: data['msg'],
                                    title:''
                                });
                            }


                        }
                   }
               });
           }
           else{
               swal({
                   icon: 'error',
                   text: 'Invalid email. Please check.',
                   title:''
               });
           }



       });
    }

   var runAddUser   =   function(idAgency,email){
       $('.add_user').click(function(e){

           e.preventDefault();
           var email        =   $('#email'+idAgency).val()
           var name         =   $('#name'+idAgency).val();
           var phone        =   $('#phone'+idAgency).val();
           var dataString   =   'name='+name+'&phone='+phone+'&email='+email;


           $.ajax({
               type: 'POST',
               url: "../api/handleAddUserFromAgency",
               dataType: "JSON",
               data: dataString,
               cache: false,

               success: function (data) {
                   if(data!=''){

                       if(data['username']!="" && data['password']!=""){
                           swal({
                               icon: data['status'],
                               text: data['msg']+' Please use the credentials for login, Username: '+data['username']+', Password: '+data['password'],
                               title:''
                           });
                       }
                       else{
                           swal({
                               icon: data['status'],
                               text: data['msg'],
                               title:''
                           });
                       }


                   }
               }
           });




       });
   }
  /* var runClickAddUser  =   function(){
       $('.add_user').click(function(e){
           e.preventDefault();


       });
   }*/

   var runEmailText =   function(idAgency){

       $('#email'+idAgency).on('keyup blur',function(){
           //console.log($(this).val().length)
            if($(this).val().length==0){

                $('.check_email').show();
                $('.add_user_main_div').hide();
                $('.add_user').hide();
                $('.map_btn').hide();
            }
            else{
                //$('.check_email').hide();;
            }

       });
   }






    runUniversityDetails();
    editButtonClick();
    runUserAddBtn();
    runCheckEmail();
    runEmailText()
;

});
