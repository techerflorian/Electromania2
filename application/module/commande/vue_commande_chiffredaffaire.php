<div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> Chiffre d'affaire</h2>
            </div>
        </div>

        


        <?php if (empty($chiffredaffaire)) { ?>
            <div class="alert alert-info text-center py-5">
                <h4>📭 Rien a aficher pour le moment</h4>
            </div>
        <?php } else { ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>cat_id</th>
                            <th>cat_libelle</th>
                            <th>total</th>
                            <th>sta_nom</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($chiffredaffaire as $row) {
                            extract(array_map("mhe", $row)); ?>
                            <tr>
                                <td><?= $cat_id ?></td>
                                <td><?= $cat_libelle ?></td>
                                <td><?= round($total,2) ?></td>
                                <td><?= $sta_nom ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>