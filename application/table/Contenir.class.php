<?php
/*
Classe créé par le générateur.
*/
class Contenir extends Table {
	public function __construct() {
		parent::__construct("contenir", "con_id");
	}
	public function selectQuantite($id) {
		$sql = "select * from contenir where con_id=:id";
		$statement = self::$link->prepare($sql);
		$statement->bindValue(":id", $id);
		$statement->execute();
		return $statement->fetch(PDO::FETCH_ASSOC);
	}
}
?>
