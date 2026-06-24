    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> commande</h2>
            </div>
            <?php if (isset($_SESSION["uti_id"]) and $_SESSION["uti_profil"]==3) { ?>
            <div class="col-md-4 text-end">
                <a class="btn btn-primary" href="<?=hlien("commande","edit","id",0)?>">
                    <i class="bi bi-plus-circle"></i> New commande
                </a>
            </div>
        </div>
        <?php } ?>


    <?php if (empty($data)) { ?>
    <div class="alert alert-info text-center py-5">
        <h4>📭 Aucun(e) commande</h4>
        <p>Commencez par en créer un(e)</p>
    </div>
    <?php } else { ?>

	<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
			<tr>
				
			<th>com_id</th>
			<th>com_date</th>
            <th>sta_nom</th>
			<th>uti_nom</th>
            <th>panier</th>
				<th class="text-center">Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $data as $row) { 
			extract(array_map("mhe",$row)); ?>
		<tr>
			
			<td><?=$com_id?></td>
			<td><?=$com_date?></td>
            <td><?= $sta_nom ?></td>
			<td><?=$uti_nom?></td>
            <td><a href="<?= hlien("commande", "panier", "id", $com_id) ?>">Panier</a></td>
            <td class="text-center">
                <a class="btn btn-sm btn-info" href="<?=hlien("commande","show","id",$com_id)?>" title="Voir">
                    <i class="bi bi-eye"></i>
                </a>
                <a class="btn btn-sm btn-warning" href="<?=hlien("commande","edit","id",$com_id)?>" title="Modifier">
                    <i class="bi bi-pencil"></i>
                </a>
                <a class="btn btn-sm btn-danger" href="<?=hlien("commande","delete","id",$com_id)?>" onclick="return confirm('Êtes-vous sûr ?');" title="Supprimer">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
    </div>
    <?php } ?>