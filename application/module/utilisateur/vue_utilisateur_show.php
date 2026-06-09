    <div class="container-fluid py-4">
	    <!-- En-tête avec titre et boutons -->
	    <div class="row mb-4">	        
        
            <div class="col-md-8">
                <h2><i class="bi bi-eye"></i> voir un(e) utilisateur</h2>
            </div>
        
	        <div class="col-md-4 text-end">
	            <button class="btn btn-secondary" type="button" onclick="history.back()">
                    <i class="bi bi-x-circle"></i> Annuler
                </button>
	            <a class="btn btn-warning" href="<?=hlien("utilisateur","edit","id",$uti_id)?>">
	                <i class="bi bi-pencil"></i> Modifier
	            </a>
	        </div>
	    </div>

    <pre>
        <?php print_r($row); ?>
    </pre>
    </div>