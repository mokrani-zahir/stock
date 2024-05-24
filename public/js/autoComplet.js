$("#fournisseur-nom").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '/search/fournisseur',
            type: 'POST',
            dataType: 'json',
            data: {
                term: request.term,
                my_variable2: "variable2_data"
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            success: function (data) {
                aData = $.map(data, function (value, key) {
                    return { label: value.nom, ...value }
                })
                console.log(aData)
                var results = $.ui.autocomplete.filter(aData, request.term)
                response(results)
            }
        })
    },
    select: function (event, ui) {
        $("#fournisseur-code").val(ui.item.code)
        $("#fournisseur-siege").val(ui.item.siege)
        $("#fournisseur-post").val(ui.item.post)
        $("#fournisseur-telephon").val(ui.item.telephon)
        $("#fournisseur-email").val(ui.item.email)
    }
});

$("#fournisseur-code").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '/search/fournisseur',
            type: 'POST',
            dataType: 'json',
            data: {
                term: request.term,
                my_variable2: "variable2_data"
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            success: function (data) {
                aData = $.map(data, function (value, key) {
                    return { label: value.code, ...value }
                })
                console.log(aData)
                var results = $.ui.autocomplete.filter(aData, request.term)
                response(results)
            }
        })
    },
    select: function (event, ui) {
        $("#fournisseur-nom").val(ui.item.nom)
        $("#fournisseur-siege").val(ui.item.siege)
        $("#fournisseur-post").val(ui.item.post)
        $("#fournisseur-telephon").val(ui.item.telephon)
        $("#fournisseur-email").val(ui.item.email)
    }
});

$("#fournisseur-siege").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '/search/fournisseur',
            type: 'POST',
            dataType: 'json',
            data: {
                term: request.term,
                my_variable2: "variable2_data"
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            success: function (data) {
                aData = $.map(data, function (value, key) {
                    return { label: value.siege, ...value }
                })
                console.log(aData)
                var results = $.ui.autocomplete.filter(aData, request.term)
                response(results)
            }
        })
    },
    select: function (event, ui) {
        $("#fournisseur-nom").val(ui.item.nom)
        $("#fournisseur-code").val(ui.item.code)
        $("#fournisseur-post").val(ui.item.post)
        $("#fournisseur-telephon").val(ui.item.telephon)
        $("#fournisseur-email").val(ui.item.email)
    }
});

$("#fournisseur-telephon").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '/search/fournisseur',
            type: 'POST',
            dataType: 'json',
            data: {
                term: request.term,
                my_variable2: "variable2_data"
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            success: function (data) {
                aData = $.map(data, function (value, key) {
                    return { label: value.telephon, ...value }
                })
                console.log(aData)
                var results = $.ui.autocomplete.filter(aData, request.term)
                response(results)
            }
        })
    },
    select: function (event, ui) {
        $("#fournisseur-nom").val(ui.item.nom)
        $("#fournisseur-siege").val(ui.item.siege)
        $("#fournisseur-post").val(ui.item.post)
        $("#fournisseur-code").val(ui.item.code)
        $("#fournisseur-email").val(ui.item.email)
    }
});

var htmlArticle = '<div class="article-1 g-1 row"onclick=autocompleteArticle(1)><div class="form-group mb-2 col-3"><div class=input-group><span class=input-group-text><i class="bi bi-upc"></i></span> <input class=form-control id=article-1-code name=article[1][code] placeholder=Code></div></div><div class="form-group mb-2 col"><div class=input-group><span class=input-group-text><i class="bi bi-database-fill"></i></span> <input class=form-control id=article-1-nom name=article[1][nom] placeholder=Nom></div></div><div class="form-group mb-2 col-2 prix"><div class=input-group><input class=form-control id=article-1-prix name=article[1][prix] placeholder=Prix type=number></div></div><div class="form-group mb-2 col-2"><div class=input-group><input class=form-control id=article-1-quantity name=article[1][quantity] placeholder=Quantity type=number></div></div><div class="form-group mb-2"style=width:50px><a class="form-control btn btn-danger is-remove"onclick=removeArticle(1)><i class="bi bi-trash3"></i></a></div></div>'
var i = 2
$('#add-article').click(function (e) {
    e.preventDefault()
    $("#articles").append(
        "<div class='row g-1'>" +
        htmlArticle.replaceAll("article[1]", "article[" + i + "]")
            .replaceAll("article-1", "article-" + i)
            .replaceAll('removeArticle(1)', 'removeArticle(' + i + ')')
        +
        "</div>"
    )
    autocompleteArticle(i)
    forceUtilisateurCMP()
    i++
})

function removeArticle(id) {
    $('.article-' + id).remove();
}


function autocompleteArticle(id) {
    $("#article-"+id+"-nom").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/search/article',
                type: 'POST',
                dataType: 'json',
                data: {
                    term: request.term,
                    my_variable2: "variable2_data"
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                success: function (data) {
                    aData = $.map(data, function (value, key) {
                        return { label: value.nom, ...value }
                    })
                    console.log(aData)
                    var results = $.ui.autocomplete.filter(aData, request.term)
                    response(results)
                }
            })
        },
        select: function (event, ui) {
            $("#article-"+id+"-code").val(ui.item.code)
        }
    });

    $("#article-"+id+"-code").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/search/article',
                type: 'POST',
                dataType: 'json',
                data: {
                    term: request.term,
                    my_variable2: "variable2_data"
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                success: function (data) {
                    aData = $.map(data, function (value, key) {
                        return { label: value.code, ...value }
                    })
                    console.log(aData)
                    var results = $.ui.autocomplete.filter(aData, request.term)
                    response(results)
                }
            })
        },
        select: function (event, ui) {
            $("#article-"+id+"-nom").val(ui.item.nom)
        }
    });
}


//Operation block

let operration = document.querySelector('#operation')
operration.addEventListener("change", function() {
    forceUtilisateurCMP();
});

function forceUtilisateurCMP(){
    let inputs = document.querySelectorAll('#articles .prix input');
    if(operration.value=="entre"){
        Array.from(inputs).forEach(item=>{
            item.type = "number"
            item.value= ""
            item.readOnly = false
        })
        return;
    }
    Array.from(inputs).forEach(item=>{
        item.type = "text"
        item.value = "CMP"
        item.readOnly = true
        console.log(inputs.value)
    })


}
