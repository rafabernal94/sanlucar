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

function mostrarAlert(texto, tipo) {
    $.notify.defaults({autoHideDelay: 2000});
    $.notify(texto, tipo);
}

function initBotonCargando(boton) {
    $(boton).prop('disabled', true).append(' <i class="fa fa-refresh fa-spin"></i>');
}

function finishBotonCargando(boton) {
    $(boton).prop('disabled', false).find('i.fa').remove();
}
