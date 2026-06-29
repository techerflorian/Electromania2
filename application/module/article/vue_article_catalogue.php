    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> Catalogue</h2>
            </div>
            <?php if (isset($_SESSION["uti_id"]) and $_SESSION["uti_profil"]==3) { ?>
            <div class="col-md-4 text-end">
                <a class="btn btn-primary" href="<?=hlien("article","edit","id",0)?>">
                    <i class="bi bi-plus-circle"></i> New article
                </a>
            </div>
            <?php } ?>
            <div class="col-md-4 text-end">
                <a class="btn btn-primary" href="<?=hlien("article","recherche")?>">
                    <i class="bi bi-plus-circle"></i> Rechercher
                </a>
            </div>
        </div>


    <?php if (empty($data)) { ?>
    <div class="alert alert-info text-center py-5">
        <h4>📭 Aucun(e) article</h4>
        <p>Commencez par en créer un(e)</p>
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
            <td><a href="<?= hlien("commande", "index", "id", $art_id) ?>">Ajouter au panier</a></td>
            <?php if (isset($_SESSION["uti_profil"]) and $_SESSION["uti_profil"]==3) { ?>
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
            <?php } ?>
		</tr>
		<?php } ?>
		</tbody>
	</table>
    </div>
    <?php } ?>