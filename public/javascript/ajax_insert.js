$('html').on('click', 'input[name="tipo_pessoa"]', function (e)
{

    if($(this).val() == 'Física')
    {
        $('input[name="identifier"]').attr('type', 'text')
        $('input[name="identifier"]').attr('placeholder', 'cpf')
        
    }
    else
    {
        $('input[name="identifier"]').attr('type', 'text')
        $('input[name="identifier"]').attr('placeholder', 'cnpj')
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
            
                $('input[name="csrf_token"]').val(response.csrf_token)
                    
            }
            else
            {
                window.location = 'http://127.0.0.1/new.teste/pages/table'
            }
        }           
    })
})