<?php
/*
Classe créé par le générateur.
*/
class Utilisateur extends Table {
	public function __construct() {
		parent::__construct("utilisateur", "uti_id");
	}

	static public function estEmailUnique(string $uti_email) {
		$sql="select * from utilisateur where uti_email=:email";
		$statement = self::$link->prepare($sql);
		$statement->bindValue(":email", $uti_email);
		$statement->execute();
		if ($statement->rowCount()>0)
			return false;
		else
			return true;
	}

	static public function selectByEmail(string $uti_email) {
		$sql="select * from utilisateur where uti_email=:email";
		$statement = self::$link->prepare($sql);
		$statement->bindValue(":email", $uti_email);
		$statement->execute();
		return $statement->fetch(PDO::FETCH_ASSOC);
	}


	static public function selectProfilByUtilisateur() {
		$sql="select * from utilisateur, profil where uti_profil=pro_id";
		$statement = self::$link->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>
