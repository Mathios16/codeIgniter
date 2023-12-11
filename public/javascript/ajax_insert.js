$('html').on('click', 'input[name="tipo_pessoa"]', function ()
{

    if($(this).val() == 'cpf')
    {
        $('input[name="identifier"]').attr('type', 'text')
        $('input[name="identifier"]').attr('placeholder', 'cpf')
        $('input[name="identifier"]').mask('000.000.000-00')
    }
    else
    {
        $('input[name="identifier"]').attr('type', 'text')
        $('input[name="identifier"]').attr('placeholder', 'cnpj')
        $('input[name="identifier"]').mask('000.000.000/0000-00')
    }

})


$('html').on('submit', '#insert', function (e)
{
    e.preventDefault();

    var form_content = $(this)[0]
    var formData = new FormData(form_content)

    var base_url = 'http://127.0.0.1/new.teste/insert'

   $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        type: 'post',
        dataType: 'json',
        data: formData, 
        url: base_url,
        success: function(response) 
        {
            if(response.error)
            {

                $('.error-name').html(response.name)
                $('.error-password').html(response.password)
                $('.error-email').html(response.email)
                $('.error-phone').html(response.phone)
                $('.error-identifier').html(response.identifier)
                $('.error-cep').html(response.cep)
            
                $('input[name="csrf_token"]').val(response.csrf_token)
                    
            }
            else
            {
                var cep = $('#cep').val()

                getCep(cep)

                window.location = 'http://127.0.0.1/new.teste/pages/table'
            }
        }           
    })
})

async function getCep(cep) { 
    const fetch = await fetch('https://viacep.com.br/ws/'+cep+'/json/?callback=', {
        mode: 'cors'
    })
    const resposta = await fetch.then((resposta) => {
        resposta.json()
    })
    const dados = await resposta.then((dados) => {
        console.log('teste')
        $('#logradouro').attr('value', dados.logradouro)
        $('#bairro').attr('value', dados.bairro)
        $('#cidade').attr('value', dados.localidade)
        $('#estado').attr('value', dados.uf)
    })
}