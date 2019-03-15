$(function() {
    "use strict";

    var runAgencySelect   =   function(){

        $('.agency').change(function(){

            var idAgency    =   $(this).val();
            var dataString  =   'id_agency='+idAgency;


            $.ajax({
                type: 'POST',
                url: "../api/handleAgencySelect",
                dataType: "JSON",
                data: dataString,
                cache: false,

                success: function (data) {
                    if(data!=""){
                        if(data['status']=='success'){
                            location.href = 'dashboard';
                        }
                    }
                }
            });
        });


    };


    var runValidation  =   function(){
        $("#addAgencyForm").validate({
            rules: {
                // simple rule, converted to {required:true}

                name :{
                    required : true
                },
                email: {
                    email : true,
                }


            },
            messages: {
                name :{
                    required: "Required an Agency Name."
                },
                email :{
                    email : "Please type a valid email",
                }


            },
            errorPlacement: function(error, element) {
                if(element.attr('type') == "text" ){
                    error.insertAfter(element.parent().find('label').last());
                }
                if(element.attr('type') == 'file'){
                    error.insertAfter(element);
                }
                if ( element.is('select') ){
                    error.insertAfter(element.parent().find('label'));
                }

            },
            submitHandler: function (form) { // for demo
                // alert('valid form submitted'); // for demo
                //return false; // for demo
                form.Submit();
            }

        });
    }


    runAgencySelect();

    runValidation();


});
