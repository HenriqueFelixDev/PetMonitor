$(document).ready(function() {
    $("div#grupo-filtros").hide();

    if (window.location.search.length > 0) {
        scrollPara("div.resultado-consulta");
    }

    $("#foto").change(function() {
        const file = $(this)[0].files[0];
        if (file.size > 2097152) {
            Modal.mostrar("Falha ao carregar imagem",
                "A imagem deve ter um tamanho máximo de 2 MB(Megabytes)", [{ nome: "OK", classe: "", onclick: function() {} }]);
        } else {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(file);

            fileReader.onloadend = function() {
                $("#foto-pet").attr("src", fileReader.result);
            }
        }

    });

    window.matchMedia("(min-width: 750px)").addListener(restaurarMenu);
});

function scrollPara(e) {
    $("html, body").animate({
        scrollTop: $(e)[0].offsetTop - 80
    });
}


function fechar(e) {
    $(e).remove();
}

function restaurarMenu(x) {
    if (x.matches) {
        $("#menu").show();
    } else {
        $("#menu").hide();
    }
}

$(document).on('click', 'a[href^="#"]', function(event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top - 70
    }, 1000);
});


function mostrarOcultarElemento(e) {
    $(e).toggle("2")
}

function mostrarOcultarSenha(checkbox, campo) {
    var checked = $(checkbox).is(":checked");
    var type = (checked) ? "text" : "password";
    $(campo).attr("type", type);
}

var Modal = {
    mostrar: function(titulo, mensagem, botoes) {
        var html = '<div id="janela-modal">' +
            '<div class="modal">' +
            '<header>' +
            titulo +
            '<div class="fechar">' +
            '<a class="btn btn-close" onclick="Modal.fechar()"><i class="fas fa-times"></i></a>' +
            '</div>' +
            '</header>' +
            '<section>' +
            mensagem +
            '</section>' +
            '<footer>' +
            '<div style="text-align:center;">';
        for (var i = 0; i < botoes.length; i++) {
            var botao = botoes[i];
            html += '<button id="btn-modal-' + i + '" class="' + botao.classe + '">' + botao.nome + '</button> ';
        }
        html += '</div>' +
            '</footer>' +
            '</div>' +
            '</div>';
        $(html).insertBefore(".container");
        for (var i = 0; i < botoes.length; i++) {
            const j = i;
            $("button#btn-modal-" + i).click(function() {
                botoes[j].onclick();
                Modal.fechar();
            });
        }
    },
    fechar: function() {
        $("#janela-modal").remove();
    }
}