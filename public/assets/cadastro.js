let cepFound = true;

function onReady() {

    validation();
    getCep()
    // $("#birthDateResp").rules("add", "blockFutureDate");

    let dddPhoneMask = function phoneMask(phone, e, currentField, options) {
        if (phone.length < 14) {
            return '(00)0000-00009';
        }
        return '(00)00000-0009';
    };
    $(".mask-cpf").mask("000.000.000-00");
    $(".mask-date").mask("00/00/0000");
    $(".mask-cnpj").mask("00.000.000/0000-00");
    $(".mask-phone-ddd").mask(dddPhoneMask, {
        onKeyPress: function onKeyPress(phone, e, currentField, options) {
            $(currentField).mask(dddPhoneMask(phone), options);
        }
    });

}

function validation() {
    let validator = null;
    // Define custom method first
    $.validator.addMethod("blockFutureDate", function (value) {
        return !(moment(value, 'DD/MM/YYYY', true) > moment());
    }, 'A data é maior que a data de hoje<br>');

    $.validator.addMethod("cepFound", function (value) {
        return !cepFound
    }, '<span id="error-message-cep" style="color: red;">Cep not found bro.</span>');

    // Initialize the form validation
    validator = $("#invoice-form").validate({
        rules: {
            date: {
                blockFutureDate: true
            },
            cep:{
                cepFound: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parent().parent());
                error.css('color', 'red');
                error.css('font-size', '12px');
            } else {
                error.insertAfter(element);
            }
        },
    });
}

function getCep() {
    $('#invoice-form input[name="cep"]').on('blur', function() {
        var cepValue = $(this).val(); // Get the value of the "cep" field
        console.log(cepValue); // Log the value to the console
        callCepApi(cepValue)
    });
}

function callCepApi(cep){
    let values = $.ajax({
        type: "GET",
        url: "https://viacep.com.br/ws/"+cep+"/json/",
        contentType: false,
        processData: false,
        dataType: "json"
    });
    values.done(function(data){
        $('#invoice-form input[name="municipio"]').val(data.localidade);  
        $('#invoice-form input[name="rua"]').val(data.logradouro);  
        $('#invoice-form input[name="estado"]').val(data.localidade);  

        // if($('#invoice-form #error-message-cep').length){
        //     $('#invoice-form #error-message-cep').remove();
        // }   

    })
    values.fail(function(error){
        cepFound = false;
        // if(!$('#invoice-form #error-message-cep').length){
        //     $('#cep')
        //         .after('<span id="error-message-cep" style="color: red;">Cep not found bro.</span><br>');
        // }
    })
    values.always(function(){
    })
}

$(document).ready(onReady);