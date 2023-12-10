$(document).ready(function () {
    $('#telefone').mask('+00(00)00000-0000')
    $('#cep').mask('00000-000')
    if($('h4').val() == 'cpf')
    {
        $('input[name="identifier"]').mask('000.000.000-00')
    }
    else
    {
        $('input[name="identifier"]').mask('000.000.000/0000-00')
    }
})