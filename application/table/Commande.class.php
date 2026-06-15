<?php
/*
Classe créé par le générateur.
*/
class Commande extends Table {
	public function __construct() {
		parent::__construct("commande", "com_id");
	}

	static public function selectCommandeByUtilisateur(	$id) {
		$sql="select * from commande, utilisateur where com_utilisateur=uti_id and uti_id=:id";
		$statement = self::$link->prepare($sql);
		$statement->bindValue(":id", $id);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	static public function selectCommande(	$id) {
		$sql="select * from commande, utilisateur where com_utilisateur=uti_id and com_id=:id";
		$statement = self::$link->prepare($sql);
		$statement->bindValue(":id", $id);
		$statement->execute();
		return $statement->fetch(PDO::FETCH_ASSOC);
	}
	
	static public function montantTotale(int $id) {
		$sql="select round(sum(con_quantite*art_prix),2) totale 
		from contenir, article where con_article=art_id and con_commande=:id";
		$statement = self::$link->prepare($sql);
		$statement->bindValue(":id", $id);
		$statement->execute();
		return $statement->fetch(PDO::FETCH_ASSOC);
	}

	static public function selectPanierByUtilisateur($id) {
		$sql="select * from commande, utilisateur, contenir, article where com_utilisateur=uti_id and con_article=art_id and con_commande=com_id and uti_id=:id";
		$statement = self::$link->prepare($sql);
		$statement->bindValue(":id", $id);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function ajouterAuPanier() {
		$sql="";
	}

	public function selectAll() : array {
		$sql="select * from commande, utilisateur where com_utilisateur=uti_id";
		$statement = self::$link->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>
