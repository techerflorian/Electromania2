<?php
/*
Classe créé par le générateur.
*/
class Article extends Table {
	public function __construct() {
		parent::__construct("article", "art_id");
	}
	static public function selectCategorieByArticle() {
		$sql="select * from article, categorie where art_categorie=art_id";
		$statement = self::$link->prepare($sql);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>
