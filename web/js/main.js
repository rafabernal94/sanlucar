function enviarAjax(url, type, data, success) {
    $.ajax({
        url: url,
        type: type,
        data: data,
        success: success
    });
}

function abrirVentana(url, titulo, ancho, alto) {
    var x = screen.width/2 - ancho/2;
    var y = screen.height/2 - alto/2;
    window.open(url, titulo, 'width='+ancho+', height='+alto+', left='+x+', top='+y);
}
