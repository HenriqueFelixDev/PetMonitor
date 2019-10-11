$(document).ready(function() {
    $("div#grupo-filtros").hide();
});

function mostrarOcultarElemento(e) {
    $(e).toggle("0.5")
}

function mostrarOcultarSenha(checkbox, campo) {
    var checked = $(checkbox).is(":checked");
    var type = (checked) ? "text" : "password";
    $(campo).attr("type", type);
}