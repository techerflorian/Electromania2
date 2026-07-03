    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> utilisateur</h2>
            </div>
            <div class="col-md-4 text-end">
                <a class="btn btn-primary" href="<?=hlien("utilisateur","edit","id",0)?>">
                    <i class="bi bi-plus-circle"></i> New utilisateur
                </a>
            </div>
        </div>


    <?php if (empty($data)) { ?>
    <div class="alert alert-info text-center py-5">
        <h4>📭 Aucun(e) utilisateur</h4>
        <p>Commencez par en créer un(e)</p>
    </div>
    <?php } else { ?>

	<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
			<tr>
				
			<th>uti_id</th>
			<th>uti_nom</th>
			<th>uti_prenom</th>
			<th>uti_adresse</th>
			<th>uti_email</th>
			<th>uti_numero_telephone</th>
			<th>commande</th>
			<th>pro_nom</th>
				<th class="text-center">Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $data as $row) { 
			extract(array_map("mhe",$row)); ?>
		<tr>
			
			<td><?=$uti_id?></td>
			<td><?=$uti_nom?></td>
			<td><?=$uti_prenom?></td>
			<td><?=$uti_adresse?></td>
			<td><?=$uti_email?></td>
			<td><?=$uti_numero_telephone?></td>
			<td><a href="<?=hlien("commande", "index", "id", $uti_id)?>">commande</a></td>
			<td><?=$pro_nom?></td>
            <td class="text-center">
                <a class="btn btn-sm btn-info" href="<?=hlien("utilisateur","show","id",$uti_id)?>" title="Voir">
                    <i class="bi bi-eye"></i>
                </a>
                <a class="btn btn-sm btn-warning" href="<?=hlien("utilisateur","edit","id",$uti_id)?>" title="Modifier">
                    <i class="bi bi-pencil"></i>
                </a>
                <a class="btn btn-sm btn-danger" href="<?=hlien("utilisateur","delete","id",$uti_id)?>" onclick="return confirm('Êtes-vous sûr ?');" title="Supprimer">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
    </div>
    <?php } ?>