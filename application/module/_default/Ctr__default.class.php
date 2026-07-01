<?php
class Ctr__default extends Ctr_controleur {

    public function __construct($action) {
		parent::__construct("_default",$action);
        $a = "a_$action";
        $this->$a();
    }
    
    public function a_index() {
        $u=new Categorie();
        $data=$u->selectAll(); 
        require $this->gabarit;   
    }

    public function a_log() {
        require $this->gabarit;   
    }

    //execute le script de création de la BDD qui doit être placé dans "document" et porter le nom de la BDD
    public function a_creerbdd()    
    {
        if (APP_ENV !== "development") {
            $_SESSION["message"][]="Action disponible uniquement en development";
            header("location:" . hlien("_default"));
            exit; 
        }
        checkAllow([3]);
        $sql = Table::creer("../document/" . DB_BDD . ".sql");
        require $this->gabarit;
    }

    public function a_dataset()
    {
        if (APP_ENV !== "development") {
            $_SESSION["message"][]="Action disponible uniquement en development";
            header("location:" . hlien("_default"));
            exit; 
        }
        checkAllow([3]);
        checkAllow([3]);
        $message = Table::dataset();
        require $this->gabarit;
    }


}

?>