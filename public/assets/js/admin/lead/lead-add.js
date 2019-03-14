$(function() {
    "use strict";

    var runDescriptionTextEditor   =   function(){

        tinymce.init({
            selector: 'textarea#remarks',  // change this value according to your html
            images_upload_url: '../api/universityDescriptionImageUpload',
            images_upload_base_path: '../',
            images_upload_credentials: true,
            plugins: '',
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,

        });


    }

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

    runDescriptionTextEditor();
    runCountryManage();

    runValidation();



});
