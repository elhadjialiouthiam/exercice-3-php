<?php
require_once "functions.php";

$message = '';
    $nbrChamps = 0;
    if (isset($_POST['btn'])){
        $nbrChamps = $_POST['nbre'];
        if (!is_chaine_numeric($nbrChamps)){
            $message = 'Veuillez saisir un entier !';
            $nbrChamps = 0;
        }elseif (is_empty($nbrChamps)) {
            $message = 'Champ obligatoire';
        }
    }

    $tabMots = [];
    $errors = [];
    $motsAvecM = [];

    if (isset($_POST['btnResultat'])){
        $nbrChamps =$_POST['nbre'];
            for ($i=0;$i<$nbrChamps;$i++){
                $mot = $_POST['mot_'.($i)];
                $tabMots[] = $mot;
                if (long_chaine($mot)>20){
                    $errors[$i][] = 'Le mot ne doit pas dépasser 20 caractères';
                }
                if (!is_chaine_alpha($mot)){
                    $errors[$i][] = 'Des lettres uniquement';
                }
                if (is_car_present_in_chaine(delete_spc_before_after($mot),' ')){
                    $errors[$i][] = 'Un seul mot';
                }
                if (isset($errors[$i]) && empty($errors[$i])){
                    unset($errors[$i]);
                }
                if(is_empty($mot)){
                    $errors[$i][] = 'Champ vide';
                }
            }
            if (empty($errors)){
                foreach ($tabMots as $m){
                    if (is_car_present_in_chaine('M',$m)){
                        $motsAvecM[] = $m;
                    }
                }
            }

    }
//var_dump($motsAvecM);
//var_dump($errors);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../qcm/bootstrap.min.css">
    <title>Exercice 3</title>
</head>
<body>
<form action="" method="POST">
    <div class="col-md-2 offset-5">
        <div class="form-group">
            <label for="nbre">Combien de Mots</label>
            <input type="text" autocomplete="off" value="<?= $nbrChamps ?>" name="nbre" id="nbre" class="form-control">
            <p class="text-danger small text-center"><?= $message ?></p>
        </div>
        <div class="col text-center">
            <button type="submit" name="btn" class="btn btn-primary">Valider</button>
            <button type="submit" name="btnA" class="btn btn-danger">Annuler</button>
        </div>
    </div>
    <div class="row mt-5">
        <?php for ($i=0;$i<$nbrChamps;$i++){ ?>
        <div class="col-md-6 offset-3 mb-2">
            <label for="">Mot N°<?= $i+1 ?></label>
            <span class="small text-danger"><?= isset($errors[$i]) ? '( '. print_error($errors[$i]) .' )' : '' ?></span>
            <input type="text" autocomplete="off" value="<?= isset($tabMots[$i]) ? $tabMots[$i] : '' ?>" name="mot_<?= $i ?>" class="form-control">
        </div>
        <?php } ?>
    </div>
    <?php if ($nbrChamps && empty($message)){ ?>
    <div class="col-md-2 offset-5">
        <button type="submit" name="btnResultat" class="btn btn-block btn-success">Résultats</button>
    </div>
    <?php } ?>
</form>

<?php if (empty($errors) && isset($_POST['btnResultat'])){ ?>
    <div class="jumbotron">
        <div class="text-center">
            <p class="display-4">Vous avez saisi <?= $nbrChamps ?> Mot(s) dont <span class="alert alert-success"><?= count($motsAvecM) ?> avec la lettre M</span></p>
        </div>
    </div>
<?php } ?>

</body>
</html>
