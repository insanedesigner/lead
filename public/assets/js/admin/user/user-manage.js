
$(function() {
    "use strict";



    var runUserInfoTable    =   function(){

        var activeTable = $('#full_table');

        activeTable.DataTable( {
            responsive: true,
            "fnDrawCallback": function( oSettings ) {
                $('.active_btn, .inactive_btn').click(function(e){
                    e.preventDefault();

                    var idUser      =   $(this).attr('data-value');
                    var status      =   $(this).attr('data-text');
                    var dataString  =   'id='+idUser+'&status='+status;

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
                            url: "../api/handleUserStatusChange",
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
                                            window.location.href = 'manage_user';
                                        });
                                }


                            }
                        });
                    })





                })




            },

        } );





       /* var dataTable = $('#full_table').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                url: "../api/load", // json datasource
                type: "post",  // method  , by default get

                error: function () {  // error handling
                    $(".employee-grid-error").html("");
                    $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display", "none");

                }
            },
            "aoColumns": [
                {'mData': 'id'},
                {'mData': 'category_name'},
                {'mData': 'stream_name'},
                {
                    'mData': 'status', "render": function ( data, type, row ) {
                        if(row.status == 'Enable'){
                            return '<a href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success"><span style="font-size:12px">Active</span></a>';
                        }
                        else{
                            return '<a href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger"><span style="font-size:12px">Inactive</span></a>';

                        }

                    },
                },
            ]
        });*/


    };

    var editButtonClick =   function(){
        $('.edit_btn').click(function(e){
            e.preventDefault();

            $('.id').val($(this).attr('data-value'));

            $('#editUserForm').submit();
        })
    };

    editButtonClick();
    runUserInfoTable();



});
