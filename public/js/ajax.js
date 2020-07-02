
/**
 * Fonction Ajax pour enregistrer et rafraichir dynamiquement
 * ici pour les Type de Festival dans AdminEditionFestival
 */ 
$( document ).ready(function() {
    $('#actionTypeFest').click(function(e) {
        var donnee = $('#type_festival_nom').val();
        /* alert(donnee) */
        $.ajax({
            url: "/admin/editionFestival/ajouter/ajax",
            type: 'POST',
            dataType: 'json',
            data: { 'donnee' : donnee},
            async: true,
            success: function(data) {
                $('#listTypeFest').empty();
                $('.typeFestivalList').empty();
                $.each(data, function (id, nom) {
                $('#listTypeFest').prepend($('<p="'+ id + '">' + nom + '</p>'))
                $('#type_festival_nom').val("");
                $('#edition_festival_typeFestivals').empty();
                $.each(data, function (id, nom) {
                    $('#edition_festival_typeFestivals').prepend($('<option value="'+ id + '">' + nom + '</option>'))
                })
                
                $('#edition_festival_typeFestivals').change();
            })
                /* console.log(data); */ },
            error: function() {
                console.log('La requete n\'a pas abouti'); }
        })
        e.preventDefault();
    })
})

/**
 * Fonction Ajax pour enregistrer et rafraichir dynamiquement
 * ici pour les Prix dans AdminEditionFestival
 */ 
$( document ).ready(function() {
    $('#actionPrix').click(function(e) {
        var prixNom = $('#prix_nom').val();
        var prixEdFest = $('#prix_editionFestival').val();
        var prixFilm = $('#prix_film').val();
        /* alert(prixNom +" " + prixFilm +" " + prixEdFest ) */
        $.ajax({
            url: "/admin/editionFestival/ajouter/prixAjax",
            type: 'POST',
            dataType: 'json',
            data: {'prixNom': prixNom , 'prixEdFest': prixEdFest, 'prixFilm': prixFilm },
            async: true,
            success: function(data) {
                $('#listPrix').empty();
                $('.prixList').empty();
                $.each(data, function (id, nom) {
                $('#listPrix').prepend($('<p="'+ id + '">' + nom + '</p>'))
                $('#prix_nom').val("");
                $('#edition_festival_Prixes').empty();
                $.each(data, function (id, nom) {
                    $('#edition_festival_Prixes').prepend($('<option value="'+ id + '">' + nom + '</option>'))
                })
                
                $('#edition_festival_Prixes').change();
            })
                /* console.log(data); */ },
            error: function() {
                console.log('La requete n\'a pas abouti'); }
        })
        e.preventDefault();
    })
})

/**
 * Fonction Ajax pour enregistrer et rafraichir dynamiquement
 * ici pour les langues dans AdminFilm
 */ 
$( document ).ready(function() {
    $('#actionLangue').click(function(e) {
        var donnee = $('#langue_nom').val();
        /* alert(donnee) */
        $.ajax({
            url: "/admin/film/ajouter/ajax",
            type: 'POST',
            dataType: 'json',
            data: { 'donnee' : donnee},
            async: true,
            success: function(data) {
                $('#listLangueDiv').empty();
                $('.LangueListP').empty();
                $.each(data, function (id, nom) {
                $('#listLangueDiv').prepend($('<p="'+ id + '">' + nom + '</p>'))
                $('#langue_nom').val("");
                $('#film_langues').empty();
                $.each(data, function (id, nom) {
                    $('#film_langues').prepend($('<option value="'+ id + '">' + nom + '</option>'))
                })
                
                $('#film_langues').change();
            })
                /* console.log(data); */ },
            error: function() {
                console.log('La requete n\'a pas abouti'); }
        })
        e.preventDefault();
    })
})

/**
 * Fonction Ajax pour enregistrer et rafraichir dynamiquement
 * ici pour les Poste dans AdminTechnicien
 */ 
$( document ).ready(function() {
    $('#actionPoste').click(function(e) {
        var posteNom = $('#poste_nom').val();
        var posteFilm = $('#poste_film').val();
        /* alert(posteNom +" " + posteFilm) */
        $.ajax({
            url: "/admin/technicien/ajouter/posteAjax",
            type: 'POST',
            dataType: 'json',
            data: {'posteNom': posteNom , 'posteFilm': posteFilm },
            async: true,
            success: function(data) {
                $('#listPoste').empty();
                $('.posteList').empty();
                $.each(data, function (id, nom) {
                $('#listPoste').prepend($('<p="'+ id + '">' + nom + '</p>'))
                $('#poste_nom').val("");
                $('#technicien_postes').empty();
                $.each(data, function (id, nom) {
                    $('#technicien_postes').prepend($('<option value="'+ id + '">' + nom + '</option>'))
                })
                
                $('#technicien_postes').change();
            })
                /* console.log(data); */ },
            error: function() {
                console.log('La requete n\'a pas abouti'); }
        })
        e.preventDefault();
    })
})