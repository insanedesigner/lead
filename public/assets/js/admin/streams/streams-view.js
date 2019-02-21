
$(function() {
    "use strict";



    var viewStream = function() {
        $(document).ready(function() {
            var fullTable       = $('#full_table').DataTable( { responsive: true } );
            var activeTable     = $('#active_table');
            activeTable.DataTable( {
                responsive: true,
                "fnDrawCallback": function( oSettings ) {
                    $('.active_btn, .inactive_btn').click(function(e){
                        e.preventDefault();
                        var idStream    =   $(this).attr('data-value');
                        var status      =   $(this).attr('data-text');
                        var dataString  =   'id_stream='+idStream+'&status='+status;

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
                                url: "../api/handleStreamStatusChange",
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


                        });




                    })




                },

            } );
            var inactiveTable   = $('#inactive_table').DataTable( { responsive: true } );


        } );
    }

    var editButtonClick =   function(){
        $('.edit_btn').click(function(e){
            e.preventDefault();
            $('#id_stream').val($(this).attr('data-value'));

            $('#streamEditForm').submit();





        })
    }

    /*var streamManageConfirm =   function(){
        $('#id="inactive_btn"').click(function(){
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function(){
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            });
        });
    }*/




    viewStream();
    editButtonClick();




});
