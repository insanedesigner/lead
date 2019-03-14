$(function() {
    "use strict";



    var runValidation  =   function(){

        $("#addLeadType").validate({
            rules: {
                // simple rule, converted to {required:true}

                name :{
                    required : true
                },


            },
            messages: {
                name :{
                    required: "Required a Lead Type Name."
                },


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




    runValidation();


});
