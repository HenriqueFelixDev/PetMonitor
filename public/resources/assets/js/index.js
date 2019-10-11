$(document).ready(function() {
    $("div#grupo-filtros").hide();

    $("#foto").change(function() {
        const file = $(this)[0].files[0];
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);

        fileReader.onloadend = function() {
            $("#foto-pet").attr("src", fileReader.result);
        }
    });
});

function mostrarOcultarElemento(e) {
    $(e).toggle("0.5")
}

function mostrarOcultarSenha(checkbox, campo) {
    var checked = $(checkbox).is(":checked");
    var type = (checked) ? "text" : "password";
    $(campo).attr("type", type);
}