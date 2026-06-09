    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> categorie</h2>
            </div>
            <div class="col-md-4 text-end">
                <a class="btn btn-primary" href="<?=hlien("categorie","edit","id",0)?>">
                    <i class="bi bi-plus-circle"></i> New categorie
                </a>
            </div>
        </div>


    <?php if (empty($data)) { ?>
    <div class="alert alert-info text-center py-5">
        <h4>📭 Aucun(e) categorie</h4>
        <p>Commencez par en créer un(e)</p>
    </div>
    <?php } else { ?>

	<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
			<tr>
				
			<th>cat_id</th>
			<th>cat_libelle</th>
				<th class="text-center">Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $data as $row) { 
			extract(array_map("mhe",$row)); ?>
		<tr>
			
			<td><?=$cat_id?></td>
			<td><?=$cat_libelle?></td>
            <td class="text-center">
                <a class="btn btn-sm btn-info" href="<?=hlien("categorie","show","id",$cat_id)?>" title="Voir">
                    <i class="bi bi-eye"></i>
                </a>
                <a class="btn btn-sm btn-warning" href="<?=hlien("categorie","edit","id",$cat_id)?>" title="Modifier">
                    <i class="bi bi-pencil"></i>
                </a>
                <a class="btn btn-sm btn-danger" href="<?=hlien("categorie","delete","id",$cat_id)?>" onclick="return confirm('Êtes-vous sûr ?');" title="Supprimer">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
    </div>
    <?php } ?>