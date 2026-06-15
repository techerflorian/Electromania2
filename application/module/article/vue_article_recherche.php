    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-pencil-square"></i> Rechercher un(e) article</h2>
            </div>
        </div>
        

        <div class="row">
            <div class="col-md-8">
                <form method="post" action="<?=hlien("article","recherche")?>">
                    <?= csrfField() ?>
                    

                        <div class='mb-3'>
                            <label for='mot' class='form-label'>Rechercher <span class='text-danger'>*</span></label>                            
                            <textarea id='mot' name='mot' size='80'  class='form-control' required><?= $mot ?></textarea>
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='art_categorie' class='form-label'>Art_categorie <span class='text-danger'>*</span></label>                                                        
                            <select id='art_categorie' name='art_categorie' class='form-select'> required<?=Table::HTMLselect('select * from categorie', 'cat_id', 'cat_libelle', $art_categorie)?></select>
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success" type="submit" name="btSubmit">
                            <i class="bi bi-check-circle"></i> Rechercher
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
                <h2><i class="bi bi-book"></i> Catalogue</h2>
            </div>


    <?php if (empty($data)) { ?>
    <div class="alert alert-info text-center py-5">
        <h4>📭 Aucun(e) article</h4>
    </div>
    <?php } else { ?>

	<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
			<tr>
			<th>art_id</th>
            <th>Article</th>
			<th>art_nom</th>
			<th>art_prix</th>
			<th>art_description</th>
			<th>art_categorie</th>
				<th class="text-center">Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $data as $row) { 
			extract(array_map("mhe",$row)); ?>
		<tr>
			
			<td><?=$art_id?></td>
            <td><img src="" /></td>
			<td><?=$art_nom?></td>
			<td><?=$art_prix?></td>
			<td><?=$art_description?></td>
			<td><?=$cat_libelle?></td>
            <td class="text-center">
                <a class="btn btn-sm btn-info" href="<?=hlien("article","show","id",$art_id)?>" title="Voir">
                    <i class="bi bi-eye"></i>
                </a>
                <a class="btn btn-sm btn-warning" href="<?=hlien("article","edit","id",$art_id)?>" title="Modifier">
                    <i class="bi bi-pencil"></i>
                </a>
                <a class="btn btn-sm btn-danger" href="<?=hlien("article","delete","id",$art_id)?>" onclick="return confirm('Êtes-vous sûr ?');" title="Supprimer">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
    </div>
    <?php } ?>