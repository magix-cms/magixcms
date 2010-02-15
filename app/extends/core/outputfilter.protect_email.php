<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Fichier :  outputfilter.protect_email.php
 * Type :     filtre de sortie
 * Nom :      protect_email
 * Rôle:     Convertie les @ en %40 pour protéger des 
 *           robots spammers.
 * -------------------------------------------------------------
 */
function smarty_outputfilter_protect_email($output, &$smarty)
{
     return preg_replace('!(\S+)@([a-zA-Z0-9\.\-]+\.([a-zA-Z]{2,3}|[0-9]{1,3}))!',
                         '$1%40$2', $output);
}
?> 
