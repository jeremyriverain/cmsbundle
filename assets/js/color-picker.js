"use strict";

$(document).ready(function(){

    $('input.color-picker').each((index, value) => {    
        $(value).spectrum({
            allowEmpty: true,
            preferredFormat: "hex",
            //showButtons: false,
            containerClassName: 'mb-1',
            showInput: true,
            cancelText: "annuler",
            chooseText: "ok",
            showInitial: true
        });
    });

    $('input.color-picker').closest('.input-field').find('label').addClass('color-active');
});
