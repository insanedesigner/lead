$(function() {
    "use strict";


    var runCountryManage =   function() {


        //Starts: Country change and default
        var idCountry   = $('.country').val();
        var event       = "default";
        var dataString  = 'id_country=' + idCountry;
        runLoadState(dataString, event);



        $('.country').change(function () {
            var idCountry = $(this).val();
            event = "change";
            var dataString = 'id_country=' + idCountry;
            runLoadState(dataString, event);
        });
    };

    var runStateManage  =   function(){
        //Starts: State change
        var idState     =   $('#state option:selected').val();
        var dataString  =   'id_state='+idState;
        var event       =   "default";
        runLoadCity(dataString, event);




        $('.state').change(function() {
            var idState     =   $(this).val();
            var dataString  =   'id_state=' + idState;
            event       =   "change";
            runLoadCity(dataString, event);
        });


    };

    var runLoadState   =   function(dataString, event){
        var stateSelected   =   "";
        $.ajax({
            type: 'POST',
            url: "../api/loadStateOnCountries",
            dataType: "JSON",
            data: dataString,
            cache: false,

            success: function (data) {
                $('.state').empty();


                var optionString    =   '<option value="0">Select a state</option>';
                $('.state').append(optionString );
                $('.state').parents().find('.state_div').addClass('focused');

                if(data!="error"){
                    for(var i=0;i<data.length;i++){
                        optionString    = '<option value="'+ data[i].id +'">'+data[i].name+'</option>';
                        $('.state').append(optionString );

                    }

                    if(event == "default"){

                        stateSelected   =   $('#state_hidden').val();
                        $('.state').find("option[value='"+stateSelected+"']").attr('selected','selected');
                        //$(".state option[value="+stateSelected+"]").attr('selected','selected');
                    }

                    runStateManage();

                }
                else{
                    $('.state').empty();
                }
            }
        });
    };
    var runLoadCity     =   function(dataString, event){
        var citySelected   =   "";
        $.ajax({
            type: 'POST',
            url: "../api/loadCityOnStates",
            dataType: "JSON",
            data: dataString,
            cache: false,

            success: function (data) {
                $('.city').empty();

                var optionString    =   '<option value="0">Select a city</option>';
                $('.city').append(optionString );
                $('.city').parents().find('.city_div').addClass('focused');

                if(data!="error"){
                    for(var i=0;i<data.length;i++){
                        optionString    = '<option value="'+ data[i].id +'">'+data[i].name+'</option>';
                        $('.city').append(optionString );
                    }

                    if(event == "default"){
                        citySelected   =   $('#city_hidden').val();

                        $('.city').find("option[value='"+citySelected+"']").attr('selected','selected');
                        //$(".city option[value="+citySelected+"]").attr('selected','selected');
                    }
                }
            }
        });

    };

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

    var runValidation  =   function(){

        $("#addUserForm").validate({
            rules: {
                // simple rule, converted to {required:true}

                first_name :{
                    required : true
                },
                password :{
                    // required : true,
                },
                cpassword :{
                    // required : true,
                    equalTo: '#password'
                },
                email :{
                    required: true,
                    email:true
                },
                phone :{
                    required: true,

                },


            },
            messages: {
                first_name :{
                    required: "Required First Name.",
                },
                password :{
                    required : "Required Password",
                },
                cpassword :{
                    required : "Required Confirm Password",
                    equalTo: "Password and Confirm Password doesn't matches"
                },
                email :{
                    required: "Required Email.",
                    email: "Type a valid email"
                },
                phone :{
                    required: "Required a Mobile Number",

                },


            },
            errorPlacement: function(error, element) {
                if(element.attr('type') == "text" ){
                    error.insertAfter(element.parent().find('label').last());
                }
                if(element.attr('type') == "password" ){
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


    runCountryManage();
    runAgencyAutoText();
    runValidation();



});
