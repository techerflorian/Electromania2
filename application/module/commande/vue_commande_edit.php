    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-pencil-square"></i> Modifier un(e) commande</h2>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="<?=hlien("commande","save")?>">
                    <?= csrfField() ?>
                    <input type="hidden" name="com_id" id="com_id" value="<?= $id ?>" />
                    
                        <div class='mb-3'>
                            <label for='com_date' class='form-label'>Com_date <span class='text-danger'>*</span></label>                            
                            <input id='com_date' name='com_date' type='datetime-local' size='80' value='<?=$com_date?>'  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='com_utilisateur' class='form-label'>Com_utilisateur <span class='text-danger'>*</span></label>                            
                            <input id='com_utilisateur' name='com_utilisateur' type='number' size='80' value='<?=$com_utilisateur?>'  class='form-control' required />
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