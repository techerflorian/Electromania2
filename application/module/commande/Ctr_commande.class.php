<?php
/*
Controleur créé par le générateur.
Controleur associé à une table (implémente le CRUD)
*/
class Ctr_commande extends Ctr_controleur implements I_crud
{

	public function __construct($action)
	{
		parent::__construct("commande", $action);
		$a = "a_$action";
		$this->$a();
	}

	function a_index()
	{
		$u = new Commande();
		$data = $u->selectAll();
		require $this->gabarit;
	}

	//$_GET["id"] : id de l'enregistrement
	function a_edit()
	{
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;
		$u = new Commande();
		if ($id > 0) {
			$row = $u->select($id);
			$panier = Commande::selectPanierByCommande($id);
		} else {
			$panier = [];
			$row = $u->emptyRecord();
		}

		extract(array_map("mhe", $row));
		require $this->gabarit;
	}

	//$_GET["id"] : id de l'enregistrement
	function a_show()
	{
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;
		$u = new Commande();
		if ($id > 0)
			$row = $u->select($id);
		else
			$row = $u->emptyRecord();

		$row = array_map("mhe", $row);
		extract($row);
		require $this->gabarit;
	}

	//$_POST
	function a_save()
	{
		if (isset($_POST["btSubmit"])) {
			if (!verifyCsrf()) {
				$_SESSION["message"][] = "Erreur de sécurité : token CSRF invalide.";
			} else {
				$u = new Commande();
				$u->save($_POST);
				if ($_POST["com_id"] == 0)
					$_SESSION["message"][] = "Le nouvel enregistrement Commande a bien été créé.";
				else
					$_SESSION["message"][] = "L'enregistrement Commande a bien été mis à jour.";
			}
		}
		header("location:" . hlien("commande"));
	}



	//param GET id 
	function a_delete()
	{
		if (isset($_GET["id"])) {
			if ($com_statut == 1) {
				$u = new Commande();
				$u->delete($_GET["id"]);
				$_SESSION["message"][] = "L'enregistrement Commande a bien été supprimé.";
			} else {
				$_SESSION["message"][] = "L'enregistrement Commande ne peut pas etre supprimé.";
			}
		}
		header("location:" . hlien("commande"));
	}

	function a_panier()
	{
		$u = new Commande();
		$com_id = 0;
		$com_date = "";
		$sta_nom = "";
		$uti_nom = "";
		$data = [];
		$commande = [];
		$totale = ["totale" => 0];

		if (isset($_SESSION["uti_id"]) && $_SESSION["uti_id"]) {
			$commandes = Commande::selectCommandeByUtilisateurConnecter($_SESSION["uti_id"]);
			if (!empty($commandes) && isset($commandes[0]["com_id"])) {
				$com_id = $commandes[0]["com_id"];
			}
		}

		if ($com_id > 0) {
			$data = $u->selectPanierByCommande($com_id);
			$commande = Commande::selectCommande($com_id);
			$totale = Commande::montantTotale($com_id);
		}

		extract(array_map("mhe", $commande));
		require $this->gabarit;
	}

	function a_commandeparutilisateur()
	{
		$u = new Commande();
		$com_id = 0;
		$com_date = "";
		$sta_nom = "";
		$uti_nom = "";
		$data = [];
		$commande = [];

		if (isset($_SESSION["uti_id"]) and $_SESSION["uti_id"])
			$data = $u->selectCommandeByUtilisateurConnecter($_SESSION["uti_id"]);
		require $this->gabarit;
	}

	function a_ajouteraupanier()
	{
		if (isset($_GET["id"]) and isset($_POST["con_quantite"]) and isset($_POST["con_article"])) {
			$_POST["con_commande"] = $_GET["id"];
			if (!verifyCsrf()) {
				$_SESSION["message"][] = "Erreur de sécurité : token CSRF invalide.";
			} else {
				$u = new Contenir();
				$u->save($_POST);
				$_SESSION["message"][] = "Le nouvel enregistrement Contenir a bien été créé.";
			}
		}
		header("location:" . hlien("commande", "panier", "id", $_GET["id"]));
	}

	function a_editquantite()
	{
		$id = isset($_GET["id"]) ? $_GET["id"] : 0;
		if (isset($_POST["btSubmit"])) {
			$u = new Contenir();
			$u->save($_POST);
			
			header("location:" . hlien("commande", "edit", "id", $_GET["com_id"]));
		} else {
			$u = new Contenir();
			$row = $u->select($id);
			if ($row != false)
				extract(array_map("mhe", $row));
			require $this->gabarit;
		}
	}
}
