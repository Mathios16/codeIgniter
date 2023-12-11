$(document).ready( function ()
{
    var username = $('.username').text()

    getUser(username).then(resposta => {
        resposta.json()
        .then(dados => {
            $('.avatar').attr('src', dados.avatar_url)
            $('.name').text(dados.name)
            let data = new Date(dados.created_at)
            $('.creation').text(data.getDate()+'/'+data.getMonth()+'/'+data.getFullYear())
            $('.url').text(dados.html_url)
        })
    })

    getRepos(username).then(resposta => {
        resposta.json()
        .then(dados => {
            dados.forEach( function(dado) {
                var linhas = document.createElement('tr')
                var elementos = [
                    document.createElement('td'),
                    document.createElement('td'),
                    document.createElement('td'),
                    document.createElement('td'),
                    document.createElement('td')
                ]

                elementos[0].appendChild(document.createTextNode(dado.name))
                linhas.appendChild(elementos[0])

                elementos[1].appendChild(document.createTextNode(dado.visibility))
                linhas.appendChild(elementos[1])

                elementos[2].appendChild(document.createTextNode(dado.html_url))
                linhas.appendChild(elementos[2])

                let data = new Date(dado.created_at)
                elementos[3].appendChild(document.createTextNode(data.getDate()+'/'+data.getMonth()+'/'+data.getFullYear()))
                linhas.appendChild(elementos[3])

                data = new Date(dado.pushed_at)
                elementos[4].appendChild(document.createTextNode(data.getDate()+'/'+data.getMonth()+'/'+data.getFullYear()))
                linhas.appendChild(elementos[4])


                document.getElementById('git-repos').appendChild(linhas)
                
            });
            
        })
    })

})

async function getUser(username) { 
    const dados = await fetch('https://api.github.com/users/'+ username, {
        mode: 'cors'
    })
    return dados
}

async function getRepos(username) { 
    const dados = await fetch('https://api.github.com/users/'+ username +'/repos', {
        mode: 'cors'
    })
    return dados
}