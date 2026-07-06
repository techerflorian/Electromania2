<?php
/*
Controleur créé par le générateur.
Controleur associé à une table (implémente le CRUD)
*/
class Ctr_article extends Ctr_controleur implements I_crud {

    public function __construct($action) {
        parent::__construct("article", $action);        
        $a = "a_$action";
        $this->$a();
    }

	function a_index() {
		checkAllow([3,2]);
		$u=new Article();
		$data=$u->selectAll();
		require $this->gabarit;
	}
	
	//$_GET["id"] : id de l'enregistrement
	function a_edit() {
		checkAllow([3]);	
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;
		$u=new Article();
		if ($id>0)
			$row=$u->select($id);
		else
			$row=$u->emptyRecord();
			
		extract(array_map("mhe",$row));	
		require $this->gabarit;		
	}

    //$_GET["id"] : id de l'enregistrement
	function a_show() {
		checkAllow([3]);	
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;
		$u=new Article();
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
		checkAllow([3]);
		if (isset($_POST["btSubmit"])) {			
            if (!verifyCsrf()) {
                $_SESSION["message"][]="Erreur de sécurité : token CSRF invalide.";                
            } else {
				$u=new Article();
				$u->save($_POST);
				if ($_POST["art_id"]==0)
					$_SESSION["message"][]="Le nouvel enregistrement Article a bien été créé.";
				else
					$_SESSION["message"][]="L'enregistrement Article a bien été mis à jour.";
			}
		}
		header("location:" . hlien("article"));
	}

	

	//param GET id 
	function a_delete() {
		checkAllow([3]);
		if (isset($_GET["id"])) {
			$u=new Article();
			$u->delete($_GET["id"]);
			$_SESSION["message"][]="L'enregistrement Article a bien été supprimé.";
		}
		header("location:" . hlien("article"));
	}

	public function a_catalogue() {
        $u=new Article();
        $data=$u->selectArticleByCategorie($_GET["id"]);
        require $this->gabarit;
    }

	function a_recherche() {
		$u=new Article();
		if (isset($_POST["mot"]) and isset($_POST["art_categorie"])) {
			extract(array_map("mhe", $_POST));
		$data=$u->rechercherArticle($mot, $art_categorie);
		} else {
			$data=[];
			$mot="";
			$art_categorie="";
		}
		require $this->gabarit;
	}
}

?>