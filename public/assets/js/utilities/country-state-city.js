function runCountryManage(){
    alert("Dsds");
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
}

function runStateManage(){
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
}

function runLoadState(dataString, event){
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
}

function runLoadCity(dataString, event){
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

}
