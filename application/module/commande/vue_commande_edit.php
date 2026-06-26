    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-pencil-square"></i> Modifier un(e) commande</h2>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="<?=hlien("commande","save")?>">
                    <?= csrfField() ?>
                    <input type="hidden" name="com_id" id="com_id" value="<?= $id ?>" />
                    
                        <div class='mb-3'>
                            <label for='com_date' class='form-label'>Com_date <span class='text-danger'>*</span></label>                            
                            <input id='com_date' name='com_date' type='datetime-local' size='80' value='<?=$com_date?>'  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='com_statut' class='form-label'>com_statut <span class='text-danger'>*</span></label>                            
                            <select id='com_statut' name='com_statut' value='<?= $com_statut ?>'  class='form-select' required<?= Table::HTMLselect('select * from statut', 'sta_id', 'sta_nom', $com_statut) ?>></select> 
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='com_utilisateur' class='form-label'>com_utilisateur <span class='text-danger'>*</span></label>                            
                            <select id='com_utilisateur' name='com_utilisateur'  class='form-select'> required<?=Table::HTMLselect('select * from utilisateur', 'uti_id', 'uti_nom', $com_utilisateur)?></select>
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success" type="submit" name="btSubmit">
                            <i class="bi bi-check-circle"></i> Enregistrer
                        </button>
                        <button class="btn btn-secondary" type="button" onclick="history.back()">
                            <i class="bi bi-x-circle"></i> Annuler
                        </button>
                    </div>
                </form>              
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> Panier</h2>
            </div>
        </div>

        <p><?= $com_id ?> - <?= $com_date ?> - <?= $com_utilisateur ?></p>


        <?php if (empty($panier)) { ?>
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
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($panier as $row) {
                            extract(array_map("mhe", $row)); ?>
                            <tr>
                                <td><?= $art_nom ?></td>
                                <td><?= $con_quantite ?></td>
                                <td><?= $con_quantite*$art_prix ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-warning" href="<?= hlien("commande", "editquantite", "id", $con_id, "com_id", $id) ?>" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" href="<?= hlien("commande", "delete", "id", $con_id) ?>" onclick="return confirm('Êtes-vous sûr ?');" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>