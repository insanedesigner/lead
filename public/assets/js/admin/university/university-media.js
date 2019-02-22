
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

    };

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
                                '<input type="file" name="file'+idDiv+'" id="image'+idDiv+'" class="dropify"  data-max-file-size="2M" />'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<a href="" class="btn waves-effect waves-light btn-rounded btn-outline-danger remove" id="remove'+idDiv+'"><i class="fa fa-times"> Remove </i></a>'+
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
                                '<a href="" class="btn btn-blue waves-effect waves-light btn-rounded btn-outline-warning add_new" id="add_new'+idDiv+'"><i class="fa fa-plus"> Add New </i></a>'+
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
                var string  =   '<a href="" class="btn btn-blue waves-effect waves-light btn-rounded btn-outline-warning add_new" id="add_new"><i class="fa fa-plus"> Add New </i></a>';
                $('.add_btn_div').append(string);
                //triggering add new
                runMediaAddNew();
            }

            if(nextId <= divCount){

                $('#media_sub_div'+nextId).attr('id', 'media_sub_div'+currentId);

                $('#image'+nextId).attr('name', 'file'+currentId);
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



        });
    };

    var runUniversityChangeToLoadMedia  =   function(){
        $('.university').change(function(){
            var idUniversity    =   $(this).val();
            var dataString      =   'id='+idUniversity;

            if(idUniversity!=''){
                $.ajax({
                    type: 'POST',
                    url: "../api/loadMediaForUniversity",
                    data: dataString,
                    dataType: "JSON",
                    cache: false,

                    success: function (data) {


                        var logoData        =   data.logoData;
                        var galleryData     =   data.galleryData;
                        var broucherData    =   data.broucherData;


                        runLogoData(logoData);          //Logo Data
                        runGalleryData(galleryData);    //Gallery Data
                        runBroucherData(broucherData); //Broucher Data






                    }
                });
            }
            else{

            }

        })
    };


    var runLogoData =   function(logoData){
        if(logoData!=null){
            $('.logo_sub_div').remove();
            var id          =   logoData.id;
            var basePath    =   logoData.base_path;
            var bucketName  =   logoData.bucket_name;
            var filename    =   logoData.filename;
            var description =   logoData.description;
            var sourceFile  =   basePath+bucketName+filename;
            var alt         =   "";

            if(logoData.alternative!=null){
                alt    =   logoData.alternative;
            }




            var string  =
                '<div class="logo_sub_div">'+
                '<div class="row el-element-overlay logo_sub_div">'+
                '<div class="col-md-12">'+
                '<h3 class="card-title m-b-20">Logo</h3>'+
                '<h6 class="card-subtitle m-b-20 text-muted"></h6>'+
                '</div>'+
                '<div class="col-lg-3 col-md-6">'+
                '<div class="card">'+
                '<div class="el-card-item">'+
                '<div class="el-card-avatar el-overlay-1"> <img src="../'+sourceFile+'" alt="'+alt+'" /></div>'+
                '<div class="el-card-content">'+
                    '<a href="" data-value="'+id+'" data-src="../'+sourceFile+'" class="logo_edit_btn">Edit</a> | <a href="" data-value="'+id+'" data-src="../'+sourceFile+'" class="logo_delete_btn">Delete</a>'+
                /*'<h3 class="box-title"></h3> <small>'+filename.split('.')[0]+'</small>'+*/
                '<br/>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<hr class="m-b-40">'+
                '</div>';


            $('.logo_main_div').append(string);
        }
        else{
            $('.logo_sub_div').remove();
            var string  =
                '<div class="logo_sub_div">'+
                '<div class="row el-element-overlay">'+
                '<div class="col-md-12">'+
                '<h4 class="card-title m-b-40 ">Logo</h4>'+
                '<h6 class="card-subtitle m-b-20 text-muted text-center" style="color:red !important;">No logo images for preview</h6>'+
                '</div>'+
                '</div>'+
                '<hr class="m-b-40">'+
                '</div>';

            $('.logo_main_div').append(string);
        }



        //Logo Edit Button
        $('.logo_edit_btn').click(function(e){
            e.preventDefault();
            var id  =   $(this).attr('data-value');
            var src =   $(this).attr('data-src');

            $('#logo_edit').modal('show');

        })





    };
    var runGalleryData  =   function(galleryData){
        var count   =   "";
        var i       =  0;


        if(galleryData!='' ){

            count   =   galleryData.length;
            $('.gallery_sub_div').remove();


            var string  =
                '<div class="gallery_sub_div">'+
                '<div class="row el-element-overlay image_div">'+
                '<div class="col-md-12">'+
                '<h3 class="card-title m-b-20">Gallery</h3>'+
                '<h6 class="card-subtitle m-b-20 text-muted"></h6>'+
                '</div>'+

                '</div>'+
                '<hr class="m-b-40">';

                $('.gallery_main_div').append(string);





            for(i=0;i<count;i++){

                var basePath    =   galleryData[i].base_path;
                var bucketName  =   galleryData[i].bucket_name;
                var filename    =   galleryData[i].filename;
                var description =   galleryData[i].description;
                var sourceFile  =   basePath+bucketName+filename;
                var alt         =   "";

                if(galleryData[i].alternative!=null){
                    alt    =   galleryData[i].alternative;
                }

                var appendString    =
                '<div class="col-lg-3 col-md-6 image_sub_div">'+
                '<div class="card">'+
                '<div class="el-card-item">'+
                '<div class="el-card-avatar el-overlay-1"> <img src="../'+sourceFile+'" alt="'+alt+'" />'+
                '</div>'+
                '<div class="el-card-content">'+
                    '<a href="">Edit</a> | <a href="">Delete</a>'+
                '<br/>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>';


                $('.image_div').append(appendString);


            }
        }
        else{

            $('.gallery_sub_div').remove();
            var string  =
                '<div class="gallery_sub_div">'+
                '<div class="row el-element-overlay image_div">'+
                '<div class="col-md-12">'+
                '<h4 class="card-title m-b-40 ">Gallery</h4>'+
                '<h6 class="card-subtitle m-b-20 text-muted text-center" style="color:red !important;">No gallery images for preview</h6>'+
                '</div>'+
                '</div>'+
                '<hr class="m-b-40">'+
                '</div>';

            $('.gallery_main_div').append(string);
        }
    };

    var runBroucherData =   function(broucherData){
        var count   =   "";
        var i       =  0;


        if(broucherData!='' ){
            count   =   broucherData.length;
            $('.broucher_sub_div').remove();


            var string  =
                '<div class="broucher_sub_div">'+
                '<div class="row el-element-overlay broucher_div">'+
                '<div class="col-md-12">'+
                '<h3 class="card-title m-b-20">E-Broucher</h3>'+
                '<h6 class="card-subtitle m-b-20 text-muted"></h6>'+
                '</div>'+
                '<hr class="m-b-40">'+
                '</div>';

            $('.broucher_main_div').append(string);





            for(i=0;i<count;i++){

                var basePath    =   broucherData[i].base_path;
                var bucketName  =   broucherData[i].bucket_name;
                var filename    =   broucherData[i].filename;
                var description =   broucherData[i].description;
                var sourceFile  =   basePath+bucketName+filename;
                var alt         =   "";
                var file        =   "";
                var ext         =   "";
                var imgSrc      =   "";

                if(filename!=''){
                    var file    =   filename.split('.')[0];
                    var ext     =   filename.split('.')[1];
                }

                if(ext=="pdf")
                {
                    var imgSrc  =   "public/assets/images/pdf.png";
                }
                else{
                    var imgSrc  =   "public/assets/images/word.png";
                }
                if(broucherData[i].alternative!=null){
                    alt    =   broucherData[i].alternative;
                }



                var appendString    =
                    '<div class="col-lg-3 col-md-6 broucher_sub_div">'+
                    '<div class="card">'+
                    '<div class="el-card-item">'+
                    '<div class="el-card-avatar el-overlay-1"> ' +
                    '<a target="_blank" href="../'+sourceFile+'"><img src="../'+imgSrc+'"/></a>'+

                    '</div>'+
                    '<div class="el-card-content">'+
                    '<small>'+file+'</small>'+
                    '</br>'+
                    '<a class="document_view" href="" >View</a> | '+
                    '<a class="document_edit" href="" >Edit</a> | '+
                    '<a class="document_delete" href="" >Delete</a> '+
                    '<br/>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';


                $('.broucher_div').append(appendString);


            }
        }
        else{

            $('.broucher_sub_div').remove();
            var string  =
                '<div class="broucher_sub_div">'+
                '<div class="row el-element-overlay broucher_div">'+
                '<div class="col-md-12">'+
                '<h4 class="card-title m-b-40 ">E-Broucher</h4>'+
                '<h6 class="card-subtitle m-b-20 text-muted text-center" style="color:red !important;">No broucher documents for preview</h6>'+
                '</div>'+
                '</div>'+
                '<hr class="m-b-40">'+
                '</div>';

            $('.broucher_main_div').append(string);
        }
    }


    //Validations
    var runUniversityLogoUploads =   function(){

        $.validator.addMethod("valueNotEquals", function(value, element, arg){

            //return arg !== value;
            return value!=0;
        }, "Please select a University.");

        $("#addLogoForm").validate({
            rules: {
                // simple rule, converted to {required:true}

                university :{
                    valueNotEquals : 'default'
                },
            },
            messages: {
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

    };
    var runUniversityImageUploads =   function(){

        $.validator.addMethod("valueNotEquals", function(value, element, arg){

            //return arg !== value;
            return value!=0;
        }, "Please select a University.");

        $("#addUniversityImages").validate({
            rules: {
                // simple rule, converted to {required:true}

                university :{
                    valueNotEquals : 'default'
                },
            },
            messages: {
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

    };
    var runUniversityBroucherUploads =   function(){

        $.validator.addMethod("valueNotEquals", function(value, element, arg){

            //return arg !== value;
            return value!=0;
        }, "Please select a University.");

        $("#addUniversityBroucher").validate({
            rules: {
                // simple rule, converted to {required:true}

                university :{
                    valueNotEquals : 'default'
                },
            },
            messages: {
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
    runUniversityChangeToLoadMedia();

    runUniversityLogoUploads();
    runUniversityValidation();
    runUniversityImageUploads();
    runUniversityBroucherUploads();



});
