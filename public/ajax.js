
$('html').on('submit', 'input[name="submit"]', function (e){
    e.preventDefaut();
    var csrf_name = $('form').attr('name')
    var csrf_hash = $('form').val()

    var email = $('input[type=text]').attr('email')
    var password = $('input[type=password]').attr('password')

    var url = $('meta[name=url]').attr("content")
    
    $.ajax({
        url: 'http://127.0.0.1/new.teste/pages',
        data: {['email']: email,['password']: password,[csrf_name]: csrf_hash}, 
        method: 'post',
        sucsses: function(response) {
            $('form').val(response.token)
            console.log(response)
        },
        error: function(response) {
            console.log(response)
        }

    })
})