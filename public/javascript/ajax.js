
$('html').on('submit', '#login', function (e)
{
    e.preventDefault();

    var form_content = $(this)[0]
    var formData = new FormData(form_content)

    var base_url = 'http://127.0.0.1/new.teste/login'


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

                $('.error-email').html(response.email)
                $('.error-password').html(response.password)
            
                $('input[name="csrf_token"]').val(response.csrf_token)

                if( response.type == 'exedTent')
                {
                    start_timer(response.tempo)
                }
                    
            }
            else
            {
                window.location = 'http://127.0.0.1/new.teste/pages/line'
            }

        },
        
        
    })
})