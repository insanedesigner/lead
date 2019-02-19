
$(function() {
    "use strict";



    var runDescriptionTextEditor   =   function(){
        /*tinymce.init({
            selector: 'textarea#desc1',  // change this value according to your html
            images_upload_url: '{{ url("api/streamDescription1ImageUpload") }}',
            images_upload_base_path: '../',
            images_upload_credentials: true,
            plugins: 'preview image link media table insertdatetime imagetools help',
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,

        });*/
        tinymce.init({
            selector: 'textarea#desc1',  // change this value according to your html
            images_upload_url: '../api/universityDescriptionImageUpload',
            images_upload_base_path: '../',
            images_upload_credentials: true,
            plugins: 'preview image link media table insertdatetime imagetools help',
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,

        });

        tinymce.init({
            selector: 'textarea#desc2',  // change this value according to your html
            images_upload_url: '../api/universityDescriptionImageUpload',
            images_upload_base_path: '../',
            images_upload_credentials: true,
            plugins: 'image link media table insertdatetime imagetools help',
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,

        });
    }

    var runSaveButtonEnableDisable   =   function(){
        $('.nav-item').click(function(){
            var tabText   =   $.trim($(this).text());

            if(tabText == "Images"){
                $('.save_btn').removeClass('btn-outline-success');
                $('.save_btn').attr('disabled','disabled');
            }
            else{
                $('.save_btn').addClass('btn-outline-success');
                $('.save_btn').prop('disabled', false);

            }

        });
    }

    var runFeaturedImageUpload =   function(){
        $('.dropify').dropify();
    };

    /*var runFeaturedThumbImageUpload   =   function(){
        $('.featured_upload_btn').bind('click',function(e){
            e.preventDefault();

            var inputImageName          =   $('#featured_image_name').val();
            var files                   =   $('#featured_image')[0].files[0];
            var bucketName              =  "FeaturedImage/";
            var activeClick             =   $(this).attr('data-value');

            runFeatureThumbImageUploadExtended(inputImageName, files, bucketName, activeClick);


        });
        $('.thumb_upload_btn').bind('click',function(e) {
            e.preventDefault();

            var inputImageName  =   $('#thumb_image_name').val();
            var files           =   $('#thumb_image')[0].files[0];
            var bucketName      =   "ThumbImage/";
            var activeClick      =   $(this).attr('data-value');

            runFeatureThumbImageUploadExtended(inputImageName, files, bucketName, activeClick);

        });

    }*/
    /*var runFeatureThumbImageUploadExtended  =   function(inputImageName, files, bucketName, activeClick){

        var basePath                =   "public/assets/images/";
        var msgString               =   "";
        var dataString              =   new FormData();

        dataString.append('file',files);
        dataString.append('image_name',inputImageName);
        dataString.append('bucket_name',bucketName);
        dataString.append('base_path',basePath);


        $.ajax({
            type:'POST',
            url: "../api/streamFeatureThumbImageUpload",
            data:dataString,
            dataType: "JSON",
            cache:false,
            processData: false,
            contentType: false,
            success:function(data){
                if(data.status == 'upload_success'){

                    var msgString  =   ' <div class="alert alert-success" >' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>' +
                        '<p style="color:green">Image uploaded successfully.</p>'+
                        '</div>';



                    if(activeClick == "featured"){

                        $('.feature_msg_div').append(msgString);
                    }
                    else{
                        $('.thumb_msg_div').append(msgString);
                    }
                }

            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });

    }*/

    var runcoursesNameMagicsuggest =   function(){
        $.ajax({
            type: 'POST',
            url: "../api/loadCoursesDetails",
            dataType: "JSON",
            cache: false,

            success: function (data) {
                $('#courses_name').magicSuggest({
                    allowFreeEntries: false,
                    autoSelect: true,
                    placeholder: 'Select a course name',
                    data: data
                });
            }
        });
    };

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
                        $(".state option[value="+stateSelected+"]").attr('selected','selected');
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

                            $(".city option[value="+citySelected+"]").attr('selected','selected');
                        }
                    }
                }
            });

    };

    var runUniversityValidation =   function(){

       /* $.validator.addMethod("imgNameDot", function(string, element) {
            return !string.match(/\./g);
        }, "Your username contains a dot!");*/
        /*$.validator.addMethod('featuredImageSelectedOrNot', function(value, element, param) {
            // param = size (in bytes)
            // element = element to validate (<input>)
            // value = value of the element (file name)
            // return this.optional(element) || (element.files[0].size <= param)
            var streamName  =   $('#stream_name').val();
            var imgName     =   $('#featured_image_name').val();
            var imgAlt      =   $('#featured_image_alt').val();
            var imgDesc     =   $('#featured_image_desc').val();

            var img         =   '';

           if($('#featured_image').val()!=''){
               var img         =   $('#featured_image')[0].files[0].name;
           }


            //console.log(img);

            if(imgName!='' || imgAlt!='' || imgDesc!=''){
                if(img!=''){
                    return true;
                }
                else{
                    return false;
                }

            }
            else{
               return true;
            }

        },"Required an image to upload");*/
       /* $.validator.addMethod('thumbImageSelectedOrNot', function(value, element, param) {
            // param = size (in bytes)
            // element = element to validate (<input>)
            // value = value of the element (file name)
            // return this.optional(element) || (element.files[0].size <= param)
            var streamName  =   $('#stream_name').val()
            var imgName     =   $('#thumb_image_name').val();
            var imgAlt      =   $('#thumb_image_alt').val()
            var imgDesc     =   $('#thumb_image_desc').val();
            var img         =   '';

            if($('#thumb_image').val()!=''){
                var img         =   $('#thumb_image')[0].files[0].name;
            }


            //console.log(img);

            if(imgName!='' || imgAlt!='' || imgDesc!=''){
                if(img!=''){
                    return true;
                }
                else{
                    return false;
                }

            }
            else{
                return true;
            }

        },"Required an image to upload");*/



        $("#addUniversityForm").validate({
            rules: {
                // simple rule, converted to {required:true}

                university_name :{
                    required : true
                },
                // featured_image: { required: true, extension: "png|jpe?g|gif", filesize: 1048576  }
                featured_image : {
                    //featuredImageSelectedOrNot:true
                },
                thumb_image : {
                    //thumbImageSelectedOrNot:true
                },
                featured_image_name : {
                    alphanumeric : true
                },
                thumb_image_name : {
                    alphanumeric : true
                }


            },
            messages: {
                university_name :{
                    required: "Required a University Name."
                },
                featured_image_name: {
                    alphanumeric: "Special characters / White spaces are not allowed"
                },
                thumb_image_name: {
                    alphanumeric: "Special characters / White spaces are not allowed"
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





    runDescriptionTextEditor();
    runFeaturedImageUpload();
    //runSaveButtonEnableDisable();
    //runFeaturedThumbImageUpload();
    runcoursesNameMagicsuggest();
    runCountryManage();
    //runStateManage();
    runUniversityValidation();



});