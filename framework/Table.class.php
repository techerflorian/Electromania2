<?php

class Table {
    // Connexion PDO à la BDD
    public static $link;
    // Nom de la table
    public string $table;
    // Nom du champ clé primaire
    public string $pk;

    /**
     * Constructeur
     */
    public function __construct(string $table, string $pk) {
        $this->table = $table;
        $this->pk = $pk;
    }

    /**
     * Retourne tous les enregistrements de la table
     */
    public function selectAll(): array {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = self::$link->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne un enregistrement précis
     */
    public function select(int $id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->pk} = :id";
        $stmt = self::$link->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne un enregistrement vide (clé => null) basé sur les colonnes
     */
    public function emptyRecord(): array {
        $fields = $this->getFields();
        return array_fill_keys($fields, null);
    }

    /**
     * Retourne le nom des champs de la table
     */
    public function getFields(): array {
        $fields = [];
		$sql = "show columns from $this->table";
		$result = self::$link->query($sql);
		foreach ($result as $row)
			$fields[] = $row["Field"];

		return $fields;
    }

    /**
     * Génère la requête UPDATE (format: champ1 = :champ1, ...)
     */
    public function updateSql(array $row): string {
        $fields = array_keys($row);
        $set = [];
        foreach ($fields as $field) {
            if ($field != $this->pk) {
                $set[] = "$field = :$field";
            }
        }
        return "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE {$this->pk} = :{$this->pk}";
    }

    /**
     * Génère la requête INSERT (format: INSERT INTO table (champs) VALUES (:champs))
     */
    public function insertSql(array $row): string {
        $fields = array_keys($row);
        $columns = implode(', ', $fields);
        $placeholders = ':' . implode(', :', $fields);
        return "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
    }

    /**
     * Enregistre (Update ou Insert) et retourne l'ID
     */
    public function save($row): int {

        //filtrer : garder les clés de row qui sont des champs de $table
        $fields=$this->getFields();
        foreach($row as $cle => $v)
            if (!in_array($cle,$fields))
                unset($row[$cle]);
        
        if (isset($row[$this->pk]) && $row[$this->pk] > 0) {
            $sql = $this->updateSql($row);
            $stmt = self::$link->prepare($sql);
            $stmt->execute($row);
            return (int)$row[$this->pk];
        } else {
            $sql = $this->insertSql($row);
            $stmt = self::$link->prepare($sql);
            $stmt->execute($row);
            return (int)self::$link->lastInsertId();
        }
    }

    /**
     * Supprime un enregistrement
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->pk} = :id";
        $stmt = self::$link->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Liste toutes les tables de la base
     */
    public static function getTablesNames(): array {
        $sql = "SHOW TABLES";
        $stmt = self::$link->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static public function creer(string $sqlfile): string
    {
        $sql = file_get_contents($sqlfile);
        Table::$link->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
        Table::$link->exec($sql);
        return $sql;
    }

    static public function dataset(): string
    {
        return "aucun dataset créé";
    }

    /**
	 * fonction générique pour générer les balises OPTION d'un SELECT
	 *
	 * @param string $sql requete sql
	 * @param string $pk nom du champ pk primaire
	 * @param string $label nom du champ à afficher dans la balise OPTION
	 * @param integer $id valeur à préselectionner
	 */
	static public function HTMLselect($sql, $pk, $label, $id)
	{

		$resultat = self::$link->query($sql);


		$s = "";
		foreach ($resultat as $tab) {
			if ($tab[$pk] == $id)
				$sel = " selected ";
			else
				$sel = "";

			$s = $s . "<option $sel value='$tab[$pk]'>$tab[$label]</option>";
		}
		return $s;
	}
}