function runElementsFloatingLabels(element){
    $(element).focusin(function(){
        $(this).closest("div").addClass('focused')
    });
    $(element).focusout(function(){
        if($(this).val()==''){
            $(this).closest("div").removeClass('focused')
        }

    });
}
