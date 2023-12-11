$('html').on('click', 'input[id="github"]', function (e)
{

    e.preventDefault()
    /*const octokit = new Octokit({
        auth: 'YOUR-TOKEN'
    })
      
    const response = await octokit.request('GET /users/{username}', {
    username: 'USERNAME',
    headers: {
        'X-GitHub-Api-Version': '2022-11-28'
    }
    })*/

    var username = $('input[name="username"]').val().split(' ').join('')

    if (username != "") 
    {

        $.getJSON("https://api.github.com/users/"+ username, function(dados) 
        {
            
        });
        
    }

})
