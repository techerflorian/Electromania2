<?php if ($message!="") {?>
    <div class="alert success"><?=$message?></div>
<?php } ?>
<form method="post">
    <p>
        <label for="menu">Re-créer le menu</label>
        <input type="checkbox" id="menu" name="menu" value="menu" >
    </p>
    <hr>
    <p><input type="button" onclick="document.querySelectorAll('.liste input').forEach( e => {e.checked=true;})" value="Tout cocher"></p>
    <div class="liste">
    <?php
    foreach($tables as $cle=>$nom) {
        $ck=in_array($nom,$cktable) ? " checked " : "";
        ?>
        <p>
            <label for="table<?=$cle?>"><?=$nom?></label>
            <input type="checkbox" id="table<?=$cle?>" name="cktable[]" value="<?=$nom?>" <?=$ck?> >
        </p>
        <?php
    }
    ?>
    </div>    

    <input type="submit" name="btSubmit" value="OK">
</form>

