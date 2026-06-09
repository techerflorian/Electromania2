<h1>Bienveu sur le site ElectroMania</h1>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> categorie</h2>
            </div>            
        </div>
    

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
            <td><img src="_images/image<?=$cat_id?>.jfif" width="300" /></td>
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
