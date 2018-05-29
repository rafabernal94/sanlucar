function enviarAjax(url, type, data, success) {
    $.ajax({
        url: url,
        type: type,
        data: data,
        success: success
    });
}
