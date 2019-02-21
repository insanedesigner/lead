
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
                                        swal("Bingo!", "Your status has been updated.", "success");
                                        //$('#active_table').html(data);
                                        //$( "#active_table" ).load();
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
    }






    runUniversityDetails();
    editButtonClick();



});
