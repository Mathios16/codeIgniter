$(document).ready(function () {

    var cep = $('#cep').text()
    getCep(cep).then(dados => {
        $('#logradouro').text(dados.logradouro)
        $('#bairro').text(dados.bairro)
        $('#localidade').text(dados.localidade)
        $('#uf').text(dados.uf)
    })
})

async function getCep(cep) { 
    await fetch('https://viacep.com.br/ws/'+cep+'/json/?callback=', {
        mode: 'cors'
    })
    .then((resposta) => {
        resposta.json()
    })
}