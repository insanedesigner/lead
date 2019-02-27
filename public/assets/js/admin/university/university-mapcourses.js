$(function() {
    "use strict";

    var runTextEditors   =   function(){
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
            selector: 'textarea#overview',  // change this value according to your html
            images_upload_url: '../api/universityDescriptionImageUpload',
            images_upload_base_path: '../',
            images_upload_credentials: true,
            plugins: 'preview image link media table insertdatetime imagetools help',
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,

        });

        tinymce.init({
            selector: 'textarea#eligibility',  // change this value according to your html
            images_upload_url: '../api/universityDescriptionImageUpload',
            images_upload_base_path: '../',
            images_upload_credentials: true,
            plugins: 'image link media table insertdatetime imagetools help',
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,

        });

        tinymce.init({
            selector: 'textarea#remarks',  // change this value according to your html
            images_upload_url: '../api/universityDescriptionImageUpload',
            images_upload_base_path: '../',
            images_upload_credentials: true,
            plugins: 'image link media table insertdatetime imagetools help',
            toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,

        });
    };


    runTextEditors();


});
