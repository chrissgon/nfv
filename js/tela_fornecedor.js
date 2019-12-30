$(window).on("load", function(){
    if(status != "true"){
    }
    if(tela != "false"){
        $("."+tela).show()
        $(".menu .aba").removeClass("aba-ativa")
        $(".menu .aba."+tela).addClass("aba-ativa")
    }else if(tela == "false"){
        $(".edicao").show()
        $(".menu .aba.edicao").addClass("aba-ativa")
    }
})

// MODAL - DESCRICAO
$(".container-modal .descricao input[type=submit]").click(function(){
    descricao = $(".container-modal .descricao textarea").val()

    $.post("php/atualizar_descricao.php", {fornecedor:id_for, descricao:descricao}).done(function(){
        $(".container-modal").fadeOut(200)
    })
})

// NAV
$(".aba.cadastro").click(function(){
    This = $(".container.cadastro")
    $("input[type=text], input[type=file], textarea", This).val("")
    $(".textarea .limite", This).html("255")
    $(".file .nome", This).html("Imagem")
})

// BUSCAR MODELOS
$(".marca .option p").click(function(){
    let marca = $(this).prop("id")
    let This = $(this).closest(".info")

    $(".modelo .select input", This).val("")
    $(".modelo .option", This).html("")

    $.get("php/buscar_modelo.php", {marca:marca}, function(data){
        array = JSON.parse(data)

        array.forEach(element => {
            id = element["id_mod"]
            modelo = element["nome_mod"]

            $(".modelo .option", This).append("<p id='"+id+"'>"+modelo+"</p>")
        })

        $(".modelo .select input", This).val(array[0]["nome_mod"])
    })
})

// LIMITE TEXTAREA
$(".textarea textarea").on("keyup", function(){
    limite = 255
    tamanho = $(this).val().length
    caracter = limite - tamanho
    
    $(".textarea .limite").html(caracter)
})

// INPUT FILE
$(".file input").change(function(e){
    nome = e.target.files[0].name
    $(".file .nome").html(nome)
})

// FILTRO - NOME
$(".edicao .pesquisa input[name=pesquisa]").keyup(function(){
    var texto = $(this).val();

    $(".lista .peca").show();
    $(".lista .peca").each(function(){
        if($(".info .nome", this).text().toUpperCase().indexOf(texto.toUpperCase()) < 0)
           $(this).hide();
    });
});

// EDICAO - FILTRO
$(".btn-float, .btn-pesquisa").click(function(){
    $(".filtro").fadeIn(100)
    setTimeout(() => {
        $(".filtro-pecas").addClass("ativo")
    }, 100);
})
$(".filtro").click(function(e){
    let modal = $(".filtro-pecas")
    if(!modal.is(e.target) && modal.has(e.target).length === 0){
        setTimeout(() => {
            $(".filtro").fadeOut(200);
        }, 200);
        $(".filtro-pecas").removeClass("ativo")
        
    }
})

// CADASTRO - PRECO
$('input[name=preco]').maskMoney({prefix:'R$ ', allowNegative: false, thousands:'.', affixesStay: false, precision: "0"});

// EDICAO - ACOES
$(".actions .editar").click(function(){
    id = $(this).closest(".peca").prop("id")

    $.post("php/buscar_peca_fornecedor.php", {id:id}, function(data){
        peca = JSON.parse(data)

        id_marca = peca.id_marca

        // id
        $(".modal.edicao .info input[name=id]").val(peca.id_peca)
        // marca
        $(".modal.edicao .info input[name=marca]").val(peca.marca)
        // modelo
        $.get("php/buscar_modelo.php", {marca:id_marca}).done(function(data){
            // done
            $(".modal.edicao .info .campo.modelo option").html("")

            modelos = JSON.parse(data)
            // foreach
            modelos.forEach(element => {
                $(".modal.edicao .info .modelo .option").append("<p id='"+element.id_mod+"'>"+element.nome_mod+"</p>")
            });
        })
        $(".modal.edicao .info input[name=modelo]").val(peca.modelo)
        // ano
        $(".modal.edicao .info input[name=ano]").val(peca.ano)
        // nome
        $(".modal.edicao .info input[name=nome]").val(peca.nome)
        // descricao
        $(".modal.edicao .info textarea[name=descricao]").val(peca.descricao)
        // preco
        $(".modal.edicao .info input[name=preco]").val(peca.preco)
        // id image
        $(".modal.edicao .info input[name=id_ima]").val(peca.imagem)
    }).done(function(){
        $(".container-modal .modal").hide()
        $(".container-modal .edicao").show()
        $(".container-modal").fadeIn(200)
    })
})

// EXCLUIR - ACOES
$(".actions .excluir").click(function(){
    This = $(this).closest(".peca")
    id = (This).prop("id")
    nome = $(".nome", This).text()

    $(".container-modal .excluir .nome").html(nome)
    $(".container-modal .excluir input[name=id]").val(id)

    // modal
    $(".container-modal .modal").hide()
    $(".container-modal .excluir").show()
    $(".container-modal").fadeIn(200)
})