    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> Panier</h2>
            </div>
        </div>

        <p><?= $com_id ?> - <?= $com_date ?> - <?= $uti_nom ?></p>
        <p>Montant total : <?= $totale["totale"] ?></p>


        <?php if (empty($data)) { ?>
            <div class="alert alert-info text-center py-5">
                <h4>📭 Aucun(e) commande</h4>
            </div>
        <?php } else { ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>art_nom</th>
                            <th>con_quantite</th>
                            <th>art_prix</th>
                            <th>art_description</th>
                            <th>Totale</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $row) {
                            extract(array_map("mhe", $row)); ?>
                            <tr>
                                <td><?= $art_nom ?></td>
                                <td><?= $con_quantite ?></td>
                                <td><?= $art_prix ?></td>
                                <td><?= $art_description ?></td>
                                <td><?= $con_quantite*$art_prix ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?= hlien("commande", "show", "id", $com_id) ?>" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a class="btn btn-sm btn-warning" href="<?= hlien("commande", "edit", "id", $com_id) ?>" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" href="<?= hlien("commande", "delete", "id", $com_id) ?>" onclick="return confirm('Êtes-vous sûr ?');" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <?php if (!empty($data)) { ?>
            <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-pencil-square"></i> Ajouter au panier</h2>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="<?=hlien("commande","ajouteraupanier", "id", $com_id)?>">
                    <?= csrfField() ?>
                    <input type="hidden" name="com_id" id="com_id" value="<?= $com_id ?>" />

                        <div class='mb-3'>
                            <label for='con_article' class='form-label'>art_id <span class='text-danger'>*</span></label>                            
                            <select id='con_article' name='con_article' value='<?= $con_article ?>'  class='form-select' required<?= Table::HTMLselect('select * from article', 'art_id', 'art_nom', $con_article) ?> ></select>
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='con_quantite' class='form-label'>con_quantite <span class='text-danger'>*</span></label>                            
                            <input id='con_quantite' name='con_quantite' type="number" size='80' value='<?= $con_quantite ?>'  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class="d-flex gap-2">
                        <button class="btn btn-success" type="submit" name="btSubmit">
                            <i class="bi bi-check-circle"></i> Ajouter au panier
                        </button>
                        <button class="btn btn-secondary" type="button" onclick="history.back()">
                            <i class="bi bi-x-circle"></i> Annuler
                        </button>
                    </div>
                </form>              
            </div>
        </div>
    </div>
    <?php } ?>