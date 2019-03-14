
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





    runUniversityDetails();
    editButtonClick();



});
