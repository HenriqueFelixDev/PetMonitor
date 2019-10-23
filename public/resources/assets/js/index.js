$(document).ready(function() {
    $("div#grupo-filtros").hide();

    if (window.location.search.length > 0) {
        scrollPara("div.resultado-consulta");
    }

    window.matchMedia("(min-width: 750px)").addListener(restaurarMenu);

    // Eventos das páginas
    $("#mostrar-senha").change(function() {
        mostrarOcultarSenha($("#mostrar-senha"), '#senha')
    })

    $("#filtro-toggle").click(function() {
        mostrarOcultarElemento('div#grupo-filtros')
    })

    $("#mostrar-senha-anterior").change(function() {
        mostrarOcultarSenha($(this), '#senha-anterior')
    })

    $("#mostrar-nova-senha").change(function() {
        mostrarOcultarSenha($(this), '#nova-senha')
    })

    $("#mostrar-rep-nova-senha").change(function() {
        mostrarOcultarSenha($(this), '#rep-nova-senha')
    })

    $(document).on('click', 'a[href^="#"]', function(event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top - 70
        }, 1000);
    })

    $("#foto").change(function() {
        const file = $(this)[0].files[0];
        if (file.size > 2097152) {
            Modal.mostrar("Falha ao carregar imagem",
                "A imagem deve ter um tamanho máximo de 2 MB(Megabytes)", [{ nome: "OK", classe: "", onclick: function() {} }]);
        } else {

            const fileReader = new FileReader();
            fileReader.readAsDataURL(file);

            fileReader.onloadend = function() {
                $("#foto-pet").css("height", "");
                $("#foto-pet").css("width", "200px");
                $("#foto-pet").attr("src", fileReader.result);
                var altura = $("#foto-pet").css("height").replace(/([^\d+\.*]+)/, "");
                var largura = $("#foto-pet").css("width").replace(/([^\d]+)/, "");

                $("#foto-pet").css("position", "relative");
                if (altura < 200) {
                    var offset = 200 / altura;
                    altura *= offset;
                    largura *= offset;
                    $("#foto-pet").css("height", altura + "px");
                    $("#foto-pet").css("width", largura + "px");
                    $("#foto-pet").css("right", (largura - 200) * 0.5 + "px");
                } else {
                    $("#foto-pet").css("bottom", (altura - 200) * 0.5 + "px");
                }
            }
        }

    })
});

var excluirRastreadorModal = function(idRastreador, nomePet, endereco) {
    Modal.mostrar('Excluir', 'Deseja realmente excluir o rastreador ' + idRastreador + ' do PET ' + nomePet + '?', [{ nome: 'Sim', classe: 'btn-primary', onclick: function() { window.location = endereco } }, { nome: 'Não', classe: 'btn-cancel', onclick: function() {} }]);
}

var excluirPetModal = function(nomePet, endereco) {
    Modal.mostrar('Excluir', 'Todos os dados de trajetos realizados pelo PET e o rastreador ao qual ele está vinculado também serão deletados. <br/><br/>Deseja realmente excluir os dados do PET ' + nomePet + '?', [{ nome: 'Sim', classe: 'btn-primary', onclick: function() { window.location = endereco; } }, { nome: 'Não', classe: 'btn-cancel', onclick: function() { console.log('teste'); } }]);
}