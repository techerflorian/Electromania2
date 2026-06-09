<?php

class Ctr__generateur extends Ctr_controleur
{
    //Les champs des tables doivent etre préfixés par les 3 premiers caracteres du nom de la table !!
    //public static $lprefixe = DB_PREFIXE_LENGTH;

    public function __construct($action)
    {
        parent::__construct("_generateur", $action);
        $a = "a_$action";
        $this->$a();
    }

    function a_index()
    {
        //liste des noms de table
        $tables = Table::getTablesNames();

        //tables cochées
        $cktable = [];

        $message = "";

        extract($_POST);
        if (isset($btSubmit)) {
            foreach ($cktable as $nom) {
                $message .= " -- Génération pour la table $nom <br>";
                $this->magicOneTable($nom);
            }

            if (isset($menu)) $this->creerMenu();
        }

        require $this->gabarit;
    }

    function a_magicAllTables()
    {
        echo "<h1><a href='index.php'>Voir le site</a></h1>";
        $sql = "show tables";
        $result = Table::$link->query($sql, PDO::FETCH_BOTH);

        foreach ($result as $row)
            $this->magicOneTable($row[0]);

        $this->creerMenu();
    }

    //génération pour une table, eventuellement passée en parametre
    function magicOneTable($table = "")
    {
        $table = $table == "" ? $_GET["table"] : $table;
        $nomCle = $this->getPK($table);
        $this->creerClassTable($table, $nomCle);
        $this->creerClassControleur($table, $nomCle);
        $this->creerVueIndex($table, $nomCle);
        $this->creerVueEdit($table, $nomCle);
        $this->creerVueShow($table, $nomCle);
    }

    private function creerClassTable($nomTable, $nomCle)
    {
        $nomClasse = ucfirst($nomTable);
        $chaine = file_get_contents("../application/module/_generateur/template/Xxx.class.txt");
        $chaine = str_replace("[nomClasse]", $nomClasse, $chaine);
        $chaine = str_replace("[nomTable]", $nomTable, $chaine);
        $chaine = str_replace("[nomCle]", $nomCle, $chaine);
        file_put_contents("../application/table/$nomClasse.class.php", $chaine);
    }

    private function creerClassControleur($nomTable, $nomCle)
    {
        $nomClasse = ucfirst($nomTable);
        $chaine = file_get_contents("../application/module/_generateur/template/Ctr_xxx.class.txt");
        $chaine = str_replace("[nomTable]", $nomTable, $chaine);
        $chaine = str_replace("[nomClasse]", $nomClasse, $chaine);
        $chaine = str_replace("[nomCle]", $nomCle, $chaine);
        @mkdir("../application/module/$nomTable");
        file_put_contents("../application/module/$nomTable/Ctr_$nomTable.class.php", $chaine);
    }

    private function creerVueIndex($nomTable, $nomCle)
    {
        $chaine = file_get_contents("../application/module/_generateur/template/xxx_index_vue.txt");
        $chaine = str_replace("[nomTable]", $nomTable, $chaine);
        $chaine = str_replace("[nomCle]", $nomCle, $chaine);
        $thnc = $this->thListeChamp($this->getChamps($nomTable));
        $chaine = str_replace("[thListeChamps]", $thnc, $chaine);
        $tdlv = $this->tdListeValeur($this->getChamps($nomTable));
        $chaine = str_replace("[tdListeValeur]", $tdlv, $chaine);
        file_put_contents("../application/module/" . $nomTable . "/vue_" . $nomTable . "_index.php", $chaine);
    }

    private function creerVueEdit($nomTable, $nomCle)
    {
        $chaine = file_get_contents("../application/module/_generateur/template/xxx_edit_vue.txt");
        $chaine = str_replace("[listeChamps]", $this->genererFormulaire($nomTable, $nomCle), $chaine);
        $chaine = str_replace("[nomTable]", $nomTable, $chaine);
        $chaine = str_replace("[nomCle]", $nomCle, $chaine);
        file_put_contents("../application/module/" . $nomTable . "/vue_" . $nomTable . "_edit.php", $chaine);
    }

    private function creerVueShow($nomTable, $nomCle)
    {
        $chaine = file_get_contents("../application/module/_generateur/template/xxx_show_vue.txt");        
        $chaine = str_replace("[nomTable]", $nomTable, $chaine);
        $chaine = str_replace("[nomCle]", $nomCle, $chaine);
        file_put_contents("../application/module/" . $nomTable . "/vue_" . $nomTable . "_show.php", $chaine);
    }

    private function creerMenu()
    {
        $chaine = file_get_contents("../application/module/_generateur/template/inc_menu.php");
        $sql = "show tables";
        $result = Table::$link->query($sql, PDO::FETCH_BOTH);
        $menu = "";
        foreach ($result as $row) {
            $s = '<?=hlien("' . $row[0] . '","index")?>';
            $menu = $menu . "<li><a class='nav-link' href='$s'>" . ucfirst($row[0]) . "</a></li>\n";
        }
        $chaine = str_replace("[menu]", $menu, $chaine);
        file_put_contents("../application/gabarit/inc_menu.php", $chaine);
    }

    private function genererFormulaire($nomTable, $nomCle)
    {
        $chaine = "";
        $result = Table::$link->query("SHOW COLUMNS FROM $nomTable", PDO::FETCH_BOTH);
        foreach ($result as $row) {

            $nom = $row["Field"];
            if ($nomCle != $nom) {
                $libelle = ucfirst($nom);                
                $phpVar = "<?=\$" . $nom . "?>";
                $inputType = "text";
                if (stripos($row["Type"], "int") !== false and $row["Key"] == "MUL") {
                    $inputType = "select";
                } else if (stripos($row["Type"], "int")!== false) {
                    $inputType = "number";
                } else if (stripos($row["Type"], "varchar")!== false) {
                    $inputType = "text";
                } else if (stripos($row["Type"], "datetime")!== false) {
                    $inputType = "datetime-local";
                } else if (stripos($row["Type"], "date")!== false) {
                    $inputType = "date";
                } else if (stripos($row["Type"], "time")!== false) {
                    $inputType = "time";
                } else if (stripos($row["Type"], "float")!== false) {
                    $inputType = "number";
                }

                if ($inputType == "select")
                    $chaine .= "
                        <div class='mb-3'>
                            <label for='$nom' class='form-label'>$libelle <span class='text-danger'>*</span></label>                                                        
                            <select id='$nom' name='$nom' class='form-select'> required"
                            . $this->getListeDeroulante($nomTable, $nom) .
                            "</select>
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>";
                else
                    $chaine .= "
                        <div class='mb-3'>
                            <label for='$nom' class='form-label'>$libelle <span class='text-danger'>*</span></label>                            
                            <input id='$nom' name='$nom' type='$inputType' size='80' value='$phpVar'  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>";
            }
        }
        return $chaine;
    }

    private function getChamps($table)
    {
        $sql = "show columns from $table";
        $result = Table::$link->query($sql);
        foreach ($result as $row) {
            $champs[] = $row["Field"];
        }
        return $champs;
    }

    function thListeChamp($ar)
    {
        $s = "";
        foreach ($ar as $valeur)
            $s .= "\n\t\t\t<th>$valeur</th>";
        return $s;
    }

    function tdListeValeur($ar)
    {
        $s = "";
        foreach ($ar as $valeur)
            $s .= "\n\t\t\t<td><?=\$" . $valeur . "?></td>";
        return $s;
    }

    private function getPK($table)
    {
        $sql = "show columns from $table";
        $result = Table::$link->query($sql);
        foreach ($result as $row) {
            if ($row["Key"] == "PRI")
                return $row["Field"];
        }
        return null;
    }

    private function getListeDeroulante($table, $fk)
    {
        $bdd = DB_BDD;
        $sql = "
        SELECT 
            TABLE_NAME,
            COLUMN_NAME,
            CONSTRAINT_NAME, 
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME 
        FROM 
            INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
        WHERE 
            REFERENCED_TABLE_SCHEMA = '$bdd' AND TABLE_NAME = '$table' and COLUMN_NAME='$fk'";
            
        $result = Table::$link->query($sql);
        $row=$result->fetch();
        
        if ($row) {
            $ref_table=$row["REFERENCED_TABLE_NAME"];
            $ref_col=$row["REFERENCED_COLUMN_NAME"];            
            $chaine="<?=Table::HTMLselect('select * from $ref_table', '$ref_col', '$ref_col', \${$fk})?>";
        } else 
            $chaine="";
        
        return $chaine;
    }
}
