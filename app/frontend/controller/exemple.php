<?php
class Example
{
    // instance de la classe
    private static $instance;

    // Un constructeur privé ; empêche la création directe d'objet
    private function __construct() 
    {
        echo 'Je suis construit';
    }

    // La méthode singleton
    public static function singleton() 
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

    // Exemple d'une méthode
    public function bark()
    {
        echo 'Woof!';
    }

    // Prévient les utilisateurs sur le clônage de l'instance
    public function __clone()
    {
        trigger_error('Le clônage n\'est pas autorisé.', E_USER_ERROR);
    }
}
?>
<?php
// Ceci échoue car le constructeur est privé
$test = new Example;

// Ceci récupère toujours une seule instance de la classe
$test = Example::singleton();
$test->bark();

// Ceci provoque une erreur E_USER_ERROR.
$test_clone = clone $test;

?>
