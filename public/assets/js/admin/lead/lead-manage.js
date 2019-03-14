
$(function() {
    "use strict";



    var runUniversityDetails = function() {
        $(document).ready(function() {

            var activeTable     = $('#full_table');
            activeTable.DataTable( {
                responsive: true,


            } );



        } );
    }

    var editButtonClick =   function(){
        $('.edit_btn').click(function(e){
            e.preventDefault();



            $('#id_lead_hidden').val($(this).attr('data-value'));
            $('#editLeadForm').submit();
        })
    };

    var runMapCourseBtnClick    =   function(){
        $('.map_lead_btn').click(function(e){
            e.preventDefault();

            $('.ms-sel-item ').text(''); //bydefault selected text keeps null

            var id  =   $(this).attr('data-value');

            $('#map_lead'+id).modal('show');    //calling model show
            runMapLeadAgencyTable(id); //calling table creation function

        });
    }

    var runSaveBtnClick  =   function(){
        $('.save_btn').click(function(e){
            e.preventDefault();
            var lead        =   $(this).attr('data-value');
            var agency      =   $('.ms-sel-item ').text();
            var dataString  =   'lead='+lead+'&agency='+agency;



            if(lead!="" && agency!=""){
                $.ajax({
                    type: 'POST',
                    url: "../api/mapLeadToAgency",
                    dataType: "JSON",
                    data: dataString,
                    cache: false,

                    success: function (data) {
                        $('.msg_sub_div').remove();
                        if(data!=""){
                            if(data['status'] == "save_success"){
                                var string  =
                                    '<div class="msg_sub_div">'+
                                    '<div class="alert alert-success">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>'+
                                    'Data saved successfully'+
                                    '</div>'+
                                    '</div>';

                                $('.msg_div').append(string);

                                runMapLeadAgencyTable(lead); //Recreatig the table after the successfull mapping
                            }
                            else if(data['status'] == "save_fail"){
                                var string  =
                                    '<div class="msg_sub_div">'+
                                    '<div class="alert alert-danger">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>'+
                                    'Failed to save data'+
                                    '</div>'+
                                    '</div>';

                                $('.msg_div').append(string);
                            }
                            else if(data['status'] == "already_mapped"){
                                var string  =
                                    '<div class="msg_sub_div">'+
                                    '<div class="alert alert-danger">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>'+
                                    'This Lead already mapped with the agency'+
                                    '</div>'+
                                    '</div>';

                                $('.msg_div').append(string);
                            }
                        }
                    }
                });
            }
            else{
                var string  =
                    '<div class="msg_sub_div">'+
                    '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>'+
                    'Please fill the empty fields'+
                    '</div>'+
                    '</div>';

                $('.msg_div').append(string);
            }





        });
    }

    var runMapLeadAgencyTable   =   function(idLead){
      $('.lead_agency_sub').remove(); //removing the sub div of table


      //creating tables dynamically
       var tableString   =
          '<div class="lead_agency_sub">'+
            '<table id="table'+idLead+'" class="display nowrap lead_agency_list'+idLead+'" style="width:100%">'+
            '<thead>'+
            '<tr>'+
            '<th>Sl.No</th>'+
            '<th>Agency Name</th>'+

        '</tr>'+
        '</thead>'+
        '<tbody>'+

        '</tbody>'+
        '</table>';


       $('.lead_agency_map_main').append(tableString); //appending to main div



            //aassigning the table data
            var dataTable = $('.lead_agency_list'+idLead).DataTable({
                "processing": true,
                "serverSide": true,
                "responsive":true,
                "ajax":{
                    url :"../api/loadMapLeadAgency", // json datasource
                    type: "post",  // method  , by default get
                    data:  {
                        id_lead: idLead,
                    },

                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");

                }
            },


            "aoColumns": [
                {'mData': 'id'},
                {'mData': 'agency_name'},
            ]

        });

    }

    var runAgencyAutoText   =   function(){
        $.ajax({
            type: 'POST',
            url: "../api/loadLead",
            dataType: "JSON",
            data: '',
            cache: false,

            success: function (data) {
                $('.agency').magicSuggest({
                    allowFreeEntries: true,
                    placeholder: 'Select an Agency',
                    maxSelection: 1,
                    data: data
                });


            }
        });

    }




    runUniversityDetails();
    editButtonClick();
    runMapCourseBtnClick();
    runSaveBtnClick();
    //runMapLeadAgencyTable();
    runAgencyAutoText();



});
