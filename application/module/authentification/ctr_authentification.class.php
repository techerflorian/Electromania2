<?php
/**
 * Module exemple : il faut adpater le nom de la table des users et ses champs
 */
class Ctr_authentification extends Ctr_controleur
{

    public function __construct($action)
    {
        parent::__construct("authentification", $action);
        $a = "a_$action";
        $this->$a();
    }

    public function a_inscription()
    {    
        extract($_POST);
        if (isset($_SESSION["uti_id"])) {
            $_SESSION["message"][]="Vous êtes déja authentifié...";
            //rediriger sur l'accueil
            header("location:" . hlien("_default"));    
            exit;
        }

        if (isset($btSubmit)) {
            // 🔐 VÉRIFIER LE TOKEN CSRF
            if (!verifyCsrf()) {
                $_SESSION["message"][]="Erreur de sécurité : token CSRF invalide.";
                //rediriger sur l'accueil
                header("location:" . hlien("_default"));    
                exit;
            }

            //vérifier que $uti_email est unique
            if (!Utilisateur::estEmailUnique($uti_email)) {
                $_SESSION["message"][]="$uti_email : cette adresse mail est déjà prise. Veuillez en saisir une autre.";
                require $this->gabarit;
                exit;
            }

            //vérifier que $uti_mdp==$uti_mdp2
            if ($uti_mdp!=$uti_mdp2) {
                $_SESSION["message"][]="La vérification du mot de passe à échouer. Veuillez vérifier votre mot de passe.";
                require $this->gabarit;    
                exit;
            }
                             
            //Tous est ok : enregistrement du nouvel utilisateur
            $_POST["uti_id"]=0;
            $_POST["uti_mdp"]=password_hash($_POST["uti_mdp"],PASSWORD_DEFAULT);
            $_POST["uti_profil"]=1;
            (new Utilisateur)->save($_POST);
            $_SESSION["message"][]="Bravo $uti_prenom ! Inscription réussie. Vous pouvez maintenant vous connecter.";
            //rediriger sur l'accueil
            header("location:" . hlien("_default"));            

        } else {
            //affichage du formulaire
            extract( (new Utilisateur())->emptyRecord() );
            require $this->gabarit;
        }
        
    }

    public function a_connexion()
    {
        if (isset($_SESSION["uti_id"])) {
            $_SESSION["message"][]="Tentative d'intrusion détectée...";
            require $this->gabarit;
            exit;
        }
        
        extract($_POST);
        if (isset($btSubmit)) {
            // 🔐 VÉRIFIER LE TOKEN CSRF
            if (!verifyCsrf()) {
                $_SESSION["message"][]="Erreur de sécurité : token CSRF invalide.";
                require $this->gabarit;
                exit;
            }

            //récupérer en bdd l'utilisateur qui posséde $uti_email
            $row=Utilisateur::selectByEmail($uti_email);

            if ($row===false) {
                $_SESSION["message"][]="$uti_email n'existe pas. Vérifiez votre saisie";
                require $this->gabarit;
                exit;
            }

            //vérification du mot de passe
            if (!password_verify($uti_mdp,$row["uti_mdp"])) {
                $_SESSION["message"][]="Mot de passe incorrect.";
                require $this->gabarit;
                exit;
            }

            //Connexion réussie
            extract($row);
            $_SESSION["uti_id"]=$uti_id;
            $_SESSION["uti_nom"]=$uti_nom;
            $_SESSION["uti_prenom"]=$uti_prenom;
            $_SESSION["uti_email"]=$uti_email;
            $_SESSION["uti_profil"]=$uti_profil;
            $data=Commande::selectCommandeByUtilisateurConnecter($_SESSION["uti_id"]);
            if ($data==false) {
                $row=[];
                $row["com_id"]=0;
                $row["com_date"]=date("Y-m-d H:i:s");
                $row["com_statut"]=1;
                $row["com_utilisateur"]=$_SESSION["uti_id"];
                //crée une commande au statut en cours récuperer l'id de cet commande et le memoriser en variable de session
                $commande=new Commande();
                $_SESSION["com_id"]=$commande->save($row);
            } else {
                $_SESSION["com_id"]=$data[0]["com_id"];
            }
            $_SESSION["message"][]="bienvenu $uti_prenom $uti_nom.";
            // 🔐 RENOUVELER LE TOKEN CSRF APRÈS CONNEXION
            renewCsrf();
            header("location:" . hlien("_default"));   

        } else {
            $uti_email="";
            require $this->gabarit;
        }
        
    }

    public function a_deconnexion()
    {
        $_SESSION=[];        
        $_SESSION["message"][]="Vous êtes bien déconnecté.";
        header("location:" . hlien("_default"));          
    }
}
