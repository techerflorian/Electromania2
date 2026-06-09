
        <h1>Création de la Base de Données</h1>
        <div class="alert alert-success">
            <strong>Succès!</strong> La base de données a été créée avec succès.
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Script SQL exécuté</h5>
            </div>
            <div class="card-body">
                <pre><code><?php echo mhe($sql); ?></code></pre>
            </div>
        </div>
        <p class="mt-3">
            <a class="btn btn-primary" href="<?= hlien('_default', 'dataset') ?>">Charger des données de test</a>
            <a class="btn btn-secondary" href="<?= hlien('_default') ?>">Retour à l'accueil</a>
        </p>