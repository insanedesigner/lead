
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



                        $.ajax({
                            type: 'POST',
                            url: "../api/handleStreamStatusChange",
                            data:   dataString,
                            dataType: "JSON",
                            cache: false,

                            success: function (data) {



                            }
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






    viewStream();
    editButtonClick();



});
