    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-pencil-square"></i> Modifier un(e) categorie</h2>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="<?=hlien("categorie","save")?>">
                    <?= csrfField() ?>
                    <input type="hidden" name="cat_id" id="cat_id" value="<?= $id ?>" />
                    
                        <div class='mb-3'>
                            <label for='cat_libelle' class='form-label'>Cat_libelle <span class='text-danger'>*</span></label>                            
                            <input id='cat_libelle' name='cat_libelle' type='text' size='80' value='<?=$cat_libelle?>'  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success" type="submit" name="btSubmit">
                            <i class="bi bi-check-circle"></i> Enregistrer
                        </button>
                        <button class="btn btn-secondary" type="button" onclick="history.back()">
                            <i class="bi bi-x-circle"></i> Annuler
                        </button>
                    </div>
                </form>              
            </div>
        </div>
    </div>