
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

                        var idUniversity   =   $(this).attr('data-value');
                        var status          =   $(this).attr('data-text');
                        var dataString      =   'id='+idUniversity+'&status='+status;

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
                                url: "../api/handleUniversityStatusChange",
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
                                                window.location.href = 'manage_university';
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

            $('#id').val($(this).attr('data-value'));
            $('#universityEditForm').submit();
        })
    };

    var mediaButtonClick    =   function(){
        $('.media_upload_btn').click(function(e){
            e.preventDefault();
            $('#id_university').val($(this).attr('data-value'));
           //$('#mediaAddForm').submit();
        });
    };

    var mapCoursesButtonClick    =   function(){
        $('.map_courses_btn').click(function(e){
            e.preventDefault();
            $('.id_mapping').val($(this).attr('data-value'));

            $('#mapCoursesAddForm').submit();
        });
    }






    runUniversityDetails();
    editButtonClick();
    mediaButtonClick();
    mapCoursesButtonClick();



});
