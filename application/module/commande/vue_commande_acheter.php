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
                            <label for='numero_carte' class='form-label'>numero_carte <span class='text-danger'>*</span></label>                            
                            <input id='numero_carte' name='numero_carte' type='number' size='80' value=''  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='date_expiration' class='form-label'>date_expiration <span class='text-danger'>*</span></label>                            
                            <input id='date_expiration' name='date_expiration' type='date' size='80' value=''  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='code_securite' class='form-label'>numero_carte <span class='text-danger'>*</span></label>                            
                            <input id='code_securite' name='code_securite' type='number' size='80' value=''  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='uti_email' class='form-label'>uti_email <span class='text-danger'>*</span></label>                            
                            <input id='uti_email' name='uti_email' type='text' size='80' value=''  class='form-control' required />
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