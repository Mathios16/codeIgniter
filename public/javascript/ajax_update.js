$('html').on('submit', '#update', function (e)
{
    e.preventDefault();

    var form_content = $(this)[0]
    var formData = new FormData(form_content)

    var base_url = $('form[id="update"]').attr('action')

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
                
                window.location = 'http://127.0.0.1/new.teste/pages/line'
            }
        }           
    })
})

async function getCep(cep) { 
    await fetch('https://viacep.com.br/ws/'+cep+'/json/?callback=', {
        mode: 'cors'

    })
    .then((resposta) => {
        resposta.json()
        .then(dados => {
            $('#logradouro').text(dados.logradouro)
            $('#bairro').text(dados.bairro)
            $('#localidade').text(dados.localidade)
            $('#uf').text(dados.uf)
        })
    })
    .catch((erro) => 
    {
        $('.error-cep').html(erro)
    })
}