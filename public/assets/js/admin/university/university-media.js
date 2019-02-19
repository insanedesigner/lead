
$(function() {
    "use strict";






    var runImageUpload =   function(){
        $('.dropify').dropify();
    };

    var runMediaDivCountCheck   =   function(){
        //function for checking the div count on page loading time, due to cache issue

        var divCount    =   0;
        $('.media_sub_div').each(function(){
            divCount    =   parseInt(divCount) + parseInt(1);
        });

        $('.media_div_count_hidden').val(divCount);

    }



    var runMediaAddNew =   function(){
        $('.add_new').click(function(e){
            e.preventDefault();



            var idDiv   =   $('.media_div_count_hidden').val();
                idDiv   =   parseInt(idDiv) +  1;


            var appendString    =
                '<div class="media_sub_div" id="media_sub_div'+idDiv+'">'+
                    '<div class="row">'+
                        '<div class="col-sm-6">'+
                            '<div class="form-group">'+
                                '<input type="file" name="file[]" id="image'+idDiv+'" class="dropify"  data-max-file-size="2M" />'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<a href="" class="btn waves-effect waves-light btn-rounded btn-outline-danger remove" id="remove'+idDiv+'">Remove</a>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                            '<div class="form-group m-b-40">'+
                                '<input type="text" id="image_name'+idDiv+'"  name="image_name'+idDiv+'" class="form-control image_name"  />'+
                                '<span class="bar"></span>'+
                                '<label for="image_name'+idDiv+'">Image Name</label>'+
                            '</div>'+
                            '<div class="form-group m-b-40">'+
                                '<input type="text" id="image_alt'+idDiv+'"  name="image_alt'+idDiv+'" class="form-control image_alt"  />'+
                                '<span class="bar"></span>'+
                                '<label for="image_alt'+idDiv+'">Alternative</label>'+
                            '</div>'+
                            '<div class="form-group m-b-40">'+
                                '<input type="text" id="image_desc'+idDiv+'"  name="image_desc'+idDiv+'" class="form-control image_desc"  />'+
                                '<span class="bar"></span>'+
                                '<label for="image_desc'+idDiv+'">Description</label>'+
                            '</div>'+
                            '<div class="form-group text-right">'+
                                '<a href="" class="btn btn-blue waves-effect waves-light btn-rounded btn-outline-warning add_new" id="add_new'+idDiv+'">Add New</a>'+
                            '</div>'+
                        '</div>'+
                        '<span class="p-20"></span>'+
                    '</div>'+
                '</div>';

            $('.media_main_div').append(appendString);

            //triggering image upload
            runImageUpload();

            //div count increment
            $('.media_div_count_hidden').val(idDiv);

            //triggering remove btn
            runMediaRemove();

            //making floating labels active
            runElementsFloatingLabels('.image_name,.image_alt, .image_desc');

            //removing add new buttons
            $(this).remove();

            //triggering add new
            runMediaAddNew();


        })
    };

    var runMediaRemove  =   function(){
        $('.remove').unbind().click(function(e){
            e.preventDefault();

            var currentRemoveBtn   =   $(this).attr('id');
            var currentId          =   currentRemoveBtn.match(/\d+/);
            var nextId             =   parseInt(currentId) + parseInt(1) ;
            var divCount           =   $('.media_div_count_hidden').val();

            //adding the add new button when deleting all the extra divs
            if(divCount==2){
                var string  =   '<a href="" class="btn btn-blue waves-effect waves-light btn-rounded btn-outline-warning add_new" id="add_new">Add New</a>';
                $('.add_btn_div').append(string);
                //triggering add new
                runMediaAddNew();
            }

            if(nextId <= divCount){

                $('#media_sub_div'+nextId).attr('id', 'media_sub_div'+currentId);
                $('#image'+nextId).attr('id', 'image'+currentId);
                $('#remove'+nextId).attr('id', 'remove'+currentId);
                $('#add_new'+nextId).attr('id', 'add_new'+currentId);

                $('#image_name'+nextId).attr('name', 'image_name'+currentId);
                $('#image_name'+nextId).attr('id', 'image_name'+currentId);

                $('#image_alt'+nextId).attr('name', 'image_alt'+currentId);
                $('#image_alt'+nextId).attr('id', 'image_alt'+currentId);

                $('#image_desc'+nextId).attr('name', 'image_desc'+currentId);
                $('#image_desc'+nextId).attr('id', 'image_desc'+currentId);

            }


            //Removing the current div
            if($('#media_sub_div'+currentId).remove()){
               var currentDivId =    $('#media_div_count_hidden').val();
               if(currentDivId>1){
                   var presentDivCount  =   parseInt(currentDivId) - parseInt(1);
                   $('#media_div_count_hidden').val(presentDivCount);
               }


            }



        })
    }

    var runElementsFloatingLabels   =   function(element){
        $(element).focusin(function(){
            $(this).closest("div").addClass('focused')
        });
        $(element).focusout(function(){
            if($(this).val()==''){
                $(this).closest("div").removeClass('focused')
            }

        });
    };


    var runUniversityValidation =   function(){

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





    runImageUpload();
    runMediaDivCountCheck();
    runMediaAddNew();
    runUniversityValidation();



});
