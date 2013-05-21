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
            "dir":"Dossier",
            "permission":"Permission",
            "extension":"Extension",
            "resolution":"Résolution",
            "php_version_is_compatible":"La version de PHP est compatible",
            "is_installed":"est installé",
            "is_not_installed":"n'est pas installé",
            "is_writable":"est accessible en écriture",
            "is_not_writable":"n'est pas accessible en écriture"
        }
    });
}( this ));