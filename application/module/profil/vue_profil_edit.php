    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-pencil-square"></i> Modifier un(e) profil</h2>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="<?=hlien("profil","save")?>">
                    <?= csrfField() ?>
                    <input type="hidden" name="pro_id" id="pro_id" value="<?= $id ?>" />
                    
                        <div class='mb-3'>
                            <label for='pro_nom' class='form-label'>Pro_nom <span class='text-danger'>*</span></label>                            
                            <input id='pro_nom' name='pro_nom' type='text' size='80' value='<?=$pro_nom?>'  class='form-control' required />
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