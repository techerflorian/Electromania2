<?php
/*
Controleur créé par le générateur.
Controleur associé à une table (implémente le CRUD)
*/
class Ctr_categorie extends Ctr_controleur implements I_crud {

    public function __construct($action) {
        parent::__construct("categorie", $action);        
        $a = "a_$action";
        $this->$a();
    }

	function a_index() {
		$u=new Categorie();
		$data=$u->selectAll();
		require $this->gabarit;
	}
	
	//$_GET["id"] : id de l'enregistrement
	function a_edit() {		
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;
		$u=new Categorie();
		if ($id>0)
			$row=$u->select($id);
		else
			$row=$u->emptyRecord();
			
		extract(array_map("mhe",$row));	
		require $this->gabarit;		
	}

    //$_GET["id"] : id de l'enregistrement
	function a_show() {		
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;
		$u=new Categorie();
		if ($id>0)
			$row=$u->select($id);
		else
			$row=$u->emptyRecord();
			
		$row=array_map("mhe",$row);	
        extract($row);
		require $this->gabarit;		
	}

	//$_POST
	function a_save() {
		if (isset($_POST["btSubmit"])) {			
            if (!verifyCsrf()) {
                $_SESSION["message"][]="Erreur de sécurité : token CSRF invalide.";                
            } else {
				$u=new Categorie();
				$u->save($_POST);
				if ($_POST["cat_id"]==0)
					$_SESSION["message"][]="Le nouvel enregistrement Categorie a bien été créé.";
				else
					$_SESSION["message"][]="L'enregistrement Categorie a bien été mis à jour.";
			}
		}
		header("location:" . hlien("categorie"));
	}

	

	//param GET id 
	function a_delete() {
		if (isset($_GET["id"])) {
			$u=new Categorie();
			$u->delete($_GET["id"]);
			$_SESSION["message"][]="L'enregistrement Categorie a bien été supprimé.";
		}
		header("location:" . hlien("categorie"));
	}
}

?>