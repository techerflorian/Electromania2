<?php
$link = mysqli_connect("localhost", "root", "", "electromania");
mysqli_set_charset($link, "utf8");

//table profil
$nbprofil = 3;
$_PROFILS = ["utilisateur", "gestionnaire", "admin"];
$sql = "insert into profil values ";
$tab = [];
for ($i = 0; $i < count($_PROFILS); $i++) {
    $nom = $_PROFILS[$i];
    $tab[] = "(null, '$nom')";
}
mysqli_query($link, $sql . implode(",", $tab));
echo "table profil : $nbprofil <br>";

//table utilisateur
$nbutilisateur = 50;
$sql = "insert into utilisateur values ";
$tab = [];
for ($i = 1; $i <= $nbutilisateur; $i++) {
    $mdp = password_hash("mdp", PASSWORD_DEFAULT);
    $profil = rand(1, $nbprofil);
    $tab[] = "(null, 'nom$i', 'prenom$i', 'adresse$i', 'email$i', '12345$i', '$mdp', '$profil')";
}
mysqli_query($link, $sql . implode(",", $tab));
echo "table utilisateur : $nbutilisateur <br>";

//table categorie
$nbcategorie = 3;
$_CATEGORIE = ["matériel informatique", "console et jeu", "éléctroménager"];
$sql = "insert into categorie values ";
$tab = [];
for ($i = 0; $i < count($_CATEGORIE); $i++) {
    $categ = $_CATEGORIE[$i];
    $tab[] = "(null, '$categ')";
}
mysqli_query($link, $sql . implode(",", $tab));
echo "table categorie : $nbcategorie <br>";

//table article
$nbarticle = 250;
$sql = "insert into article values ";
$tab = [];
for ($i = 1; $i <= $nbarticle; $i++) {
    $cat = rand(1, $nbcategorie);
    $prix = rand(1, 500) . "." . rand(0, 99);
    $tab[] = "(null, 'nom$i', '$prix', 'description$i', '$cat')";
}
mysqli_query($link, $sql . implode(",", $tab));
echo "table article : $nbarticle <br>";

//table statut
$nbstatut = 2;
$_STATUT=["en cours", "valider"];
$sql = "insert into statut values ";
$tab = [];
for ($i = 0; $i < count($_STATUT); $i++) {
    $nom = $_STATUT[$i];
    $tab[] = "(null, '$nom')";
}
mysqli_query($link, $sql . implode(",", $tab));
echo "table statut : $nbstatut <br>";


//table commande
$nbcommande = 200;
$sql = "insert into commande values ";
$tab = [];
for ($i = 1; $i <= $nbcommande; $i++) {
    
    $ts = mktime(rand(0,23), 0, 0, rand(1,12), 10, 2026);
    $date = date("Y-m-d H:i:s", $ts);
    $utilisateur = rand(1, $nbutilisateur);
    $statut = mt_rand(1, $nbstatut);
    $tab[] = "(null, '$date', '$statut','$utilisateur')";
}
mysqli_query($link, $sql . implode(",", $tab));
echo "table commande : $nbcommande <br>";


//table contenir
$nbcontenir = 20;
$sql = "insert into contenir values ";
$tab = [];
for ($i = 1; $i <= $nbcommande; $i++) {
    for ($j = 0; $j <= $nbcontenir; $j++) {
        $quantite = rand(1, 5);
        $idarticle = rand(1, $nbarticle);
        $tab[] = "(null, '$quantite', '$i', '$idarticle')";
    }
}
mysqli_query($link, $sql . implode(",", $tab));
echo "table contenir : $nbcontenir <br>";
