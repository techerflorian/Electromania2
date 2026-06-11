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