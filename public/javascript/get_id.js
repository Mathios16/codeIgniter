$('html').on('click', 'button', function () {
    var linha = $(this).closest('tr')
    $('a').attr('href', 'http://127.0.0.1/new.teste/update_line/'+linha.find('td:eq(0)').text())
})