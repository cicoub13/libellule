<?php
class DataBase {
 /* pour être sûr qu'il n'y a qu'une et une seule instance */
  private static $instance;

  /* le lien de connexion BD (objet PDO) */
  protected $connexion;

  /* constructeur privé qui initialise la connexion*/
  private function __construct() {
    /* création d'un objet PDO avec les constantes définies dans la configuration */
    $this->connexion = new PDO('sqlite:/home/pi/libellule/libellule.db');
    /* mettre Exception comme mode d'erreur */
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  /* clonage impossible */
  private function __clone() {}

  /**
   * Accéder à l'UNIQUE instance de la classe
   */
  static public function getInstance() {
    if (! (self::$instance instanceof self)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Accesseur de la connexion
   */
  public function getConnexion() {
    return $this->connexion;
  }
}

?>
