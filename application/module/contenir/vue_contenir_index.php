    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-book"></i> contenir</h2>
            </div>
        </div>


    <?php if (empty($data)) { ?>
    <div class="alert alert-info text-center py-5">
        <h4>📭 Aucun(e) contenir</h4>
        <p>Commencez par en créer un(e)</p>
    </div>
    <?php } else { ?>

	<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
			<tr>
				
			<th>con_id</th>
			<th>con_quantite</th>
			<th>con_commande</th>
			<th>con_article</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $data as $row) { 
			extract(array_map("mhe",$row)); ?>
		<tr>
			
			<td><?=$con_id?></td>
			<td><?=$con_quantite?></td>
			<td><?=$con_commande?></td>
			<td><?=$con_article?></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
    </div>
    <?php } ?>