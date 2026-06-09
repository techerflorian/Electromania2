    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> Panier</h2>
            </div>
        </div>


    <?php if (empty($data)) { ?>
    <div class="alert alert-info text-center py-5">
        <h4>📭 Aucun(e) commande</h4>
    </div>
    <?php } else { ?>

	<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
			<tr>
				
			<th>com_id</th>
			<th>com_date</th>
			<th>uti_nom</th>
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
			<td><?=$uti_nom?></td>
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