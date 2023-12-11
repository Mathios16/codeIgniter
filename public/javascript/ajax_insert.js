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

$('#cep').blur( function() {
    var cep = $('input[name="cep"]').val()
    if( cep == null)
        return
    console.log(cep)
    getCep(cep).then(resposta => {
        resposta.json()
        .then((dados) => {
            console.log(dados)
            $('input[name="logradouro"]').attr('value',dados.logradouro)
            $('input[name="bairro"]').attr('value',dados.bairro)
            $('input[name="cidade"]').attr('value',dados.localidade)
            $('input[name="estado"]').attr('value', dados.uf)
        })
    })
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
                $('.error-github').html(response.github)
            
                $('input[name="csrf_token"]').val(response.csrf_token)
                    
            }
            else
            {
                window.location = 'http://127.0.0.1/new.teste/pages/table'
            }
        }           
    })
})

async function getCep(cep) { 
    const dados = await fetch('https://viacep.com.br/ws/'+cep+'/json/?callback=', {
        mode: 'cors'
    })
    return dados
}
