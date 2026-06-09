    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="bi bi-pencil-square"></i> Modifier un(e) utilisateur</h2>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="<?=hlien("utilisateur","save")?>">
                    <?= csrfField() ?>
                    <input type="hidden" name="uti_id" id="uti_id" value="<?= $id ?>" />
                    
                        <div class='mb-3'>
                            <label for='uti_nom' class='form-label'>Uti_nom <span class='text-danger'>*</span></label>                            
                            <input id='uti_nom' name='uti_nom' type='text' size='80' value='<?=$uti_nom?>'  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='uti_prenom' class='form-label'>Uti_prenom <span class='text-danger'>*</span></label>                            
                            <input id='uti_prenom' name='uti_prenom' type='text' size='80' value='<?=$uti_prenom?>'  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='uti_adresse' class='form-label'>Uti_adresse <span class='text-danger'>*</span></label>                            
                            <input id='uti_adresse' name='uti_adresse' type='text' size='80' value='<?=$uti_adresse?>'  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='uti_numero_telephone' class='form-label'>Uti_numero_telephone <span class='text-danger'>*</span></label>                            
                            <input id='uti_numero_telephone' name='uti_numero_telephone' type='text' size='80' value='<?=$uti_numero_telephone?>'  class='form-control' required />
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='uti_profil' class='form-label'>Uti_profil <span class='text-danger'>*</span></label>                                                        
                            <select id='uti_profil' name='uti_profil' class='form-select'> required<?=Table::HTMLselect('select * from profil', 'pro_id', 'pro_nom', $uti_profil)?></select>
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