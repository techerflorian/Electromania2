<?php
/*
Classe créé par le générateur.
*/
class Article extends Table {
	public function __construct() {
		parent::__construct("article", "art_id");
	}
	public function selectAll() : array {
		$sql="select * from article, categorie where art_categorie=cat_id";
		$statement = self::$link->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>
