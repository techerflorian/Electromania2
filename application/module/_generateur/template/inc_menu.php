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
        [menu]
      </ul>
      <ul class="navbar-nav ml-auto">
        <li><a class="nav-link" href="<?= hlien("_default", "creerbdd") ?>">Créer BDD</a></li>
        <li><a class="nav-link" href='<?= hlien("_default", "dataset") ?>'>Jeu de données</a></li>
        <li><a class="nav-link" href="<?= hlien("authentification", "deconnexion") ?>">Déconnexion</a></li>
        <li><a class="nav-link" href='<?= hlien("authentification", "connexion") ?>'>Connexion</a></li>
        <li><a class="nav-link" href='<?= hlien("authentification", "inscription") ?>'>Inscription</a></li>
        <li><a class="nav-link" href='<?= hlien("_default", "log") ?>'>log</a></li>
      </ul>
    </div>
  </div>
</nav>