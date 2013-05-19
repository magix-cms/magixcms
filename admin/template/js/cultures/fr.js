(function( window, undefined ) {

    var Globalize;

    if ( typeof require !== "undefined"
        && typeof exports !== "undefined"
        && typeof module !== "undefined" ) {
        // Assume CommonJS
        Globalize = require( "globalize" );
    } else {
        // Global variable
        Globalize = window.Globalize;
    }
    Globalize.addCultureInfo( "fr", {
        messages: {
            "heading":"Titre",
            "content":"Contenu",
            "nickname":"Pseudo",
            "view":"Voir",
            "add":"Ajouter",
            "edit":"Editer",
            "remove":"Supprimer",
            "cancel":"Annuler",
            "move":"Déplacer",
            "copy":"Copier",
            "activate":"Activer",
            "deactivate":"Désactiver",
            "name":"Nom",
            "date_of_change":"Date de modification",
            "change_of_status":"Modification du statut",
            "question_change_of_status":"Voulez-vous modifier le statut ?",
            "delete_item":"Suppression d'élément",
            "delete_this_item":"Voulez-vous supprimer cet élément ?",
            "class_name":"Nom de la classe",
            "menu_display":"Afficher l'élément dans le menu",
            "language":"Langue",
            "default":"Défaut",
            "activate_language":"Activer la langue",
            "redactor":"Rédacteur",
            "date_register":"Date sauvegarde",
            "date_publisher":"Date de publication",
            "add_tag":"Ajouter un tag",
            "management_child_pages":"Gestion des pages enfant de",
            "move_page":"Déplacement de la page",
            "level":"Niveau",
            "role":"Rôle",
            "category":"Catégorie",
            "subcategory":"Sous catégorie",
            "product":"Produit"
        }
    });
}( this ));