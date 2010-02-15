<?php
/*
* This plug is used only for smarty and directed by
* Gérits Aurélien for clashdesign.
* It is protected by magix cms, and can not under any circumstances be copied, distributed to a third person.
* firststring
* -------------------------------------------------------------
* File:     modifier..php
* Type:     function
* Name:     filter
* Purpose:  replace string
* Authors : Gérits Aurélien
* Examples: 
* {'string'|firststring}
* -------------------------------------------------------------
*/
 function smarty_modifier_firststring($string){   
     return magixcjquery_string_convert::ucfirst($string);
} 
?>