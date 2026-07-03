<nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</span></a>
        </li>
        <?php if (isset($_SESSION["uti_profil"]) and $_SESSION["uti_profil"]==3) { ?>
        <li><a class='nav-link' href='<?=hlien("article","index")?>'>Article</a></li>
<li><a class='nav-link' href='<?=hlien("categorie","index")?>'>Categorie</a></li>
<li><a class='nav-link' href='<?=hlien("commande","index")?>'>Commande</a></li>
<li><a class='nav-link' href='<?=hlien("profil","index")?>'>Profil</a></li>
<li><a class='nav-link' href='<?=hlien("utilisateur","index")?>'>Utilisateur</a></li>
<?php } else if (isset($_SESSION["uti_id"]) and $_SESSION["uti_profil"]==1) { ?>
<li><a class='nav-link' href='<?=hlien("commande","panier")?>'>Panier</a></li>
<li><a class='nav-link' href='<?=hlien("commande","commandeparutilisateur","id",$_SESSION["uti_id"])?>'>Mes commandes</a></li>
<?php } else if (isset($_SESSION["uti_id"]) and $_SESSION["uti_profil"]==2) { ?>
<li><a class='nav-link' href='<?=hlien("article","index")?>'>Article</a></li>
<li><a class='nav-link' href='<?=hlien("commande","index")?>'>ommandes utilisateur</a></li>
      </ul>
      <?php } ?>
      <ul class="navbar-nav ml-auto">
        <?php if (isset($_SESSION["uti_id"]) and $_SESSION["uti_id"]) { ?>
        <li><a class="nav-link" href="<?= hlien("authentification", "deconnexion") ?>">Déconnexion</a></li>
        <li class="p-1 m-2 fw-bold bg-primary text-white"><?= $_SESSION["uti_nom"] . "[" . $_SESSION["uti_profil"] . "]" . $_SESSION["com_id"] ?></li>
        <?php } else { ?>
        <li><a class="nav-link" href='<?= hlien("authentification", "connexion") ?>'>Connexion</a></li>
        <li><a class="nav-link" href='<?= hlien("authentification", "inscription") ?>'>Inscription</a></li>
      </ul>
      <?php } ?>
    </div>
  </div>
</nav>