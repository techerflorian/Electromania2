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
                            <textarea id='mot' name='mot' size='80'  class='form-control' required><?= $mot?></textarea>
                            <small class='form-text text-muted'>aide à la saisie</small>
                        </div>
                        <div class='mb-3'>
                            <label for='art_categorie' class='form-label'>Art_categorie <span class='text-danger'>*</span></label>                                                        
                            <select id='art_categorie' name='art_categorie' class='form-select'> required<?=Table::HTMLselect('select * from categorie', 'cat_id', 'cat_libelle', $art_categorie)?></select>
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