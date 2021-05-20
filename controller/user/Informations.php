<?php

class Informations extends View{
    
    protected $pageTitle = 'Informations';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';
        ob_start();

        if(isset($user) && $user){
            if(isset($_POST) && $_POST){
                $return = '';
                $bleached=[];
                foreach($_POST as $key=>$value){
                    if($return !== '') break;
                    if($value){
                        if($key=='bio'){
                            if(!is_string($value) || strlen($value)>1000) $return = 'invalid_bio';
                        } 
                        else if($key=='country' || $key=='city'){
                            if(!is_string($value) || strlen($value)>40 || preg_match('~[0-9]+~', $value)) $return = 'invalid_location';
                        }  
                        else if($key=='lastname' || $key=='firstname'){
                            if(!is_string($value) || strlen($value)>40 || preg_match('~[0-9]+~', $value)) $return = 'invalid_name';
                        } 
                        else if($key=='phone'){
                            if(!is_string($value) && strlen($value)>15 || preg_match('~[a-zA-Z]+~', $value)) $return = 'invalid_phone';
                        } 
                        else if($key=='birthdate'){
                            $date = DateTime::createFromFormat('Y-m-d', $value);
                            if($date->format('Y-m-d')!==$value) $return = 'invalid_date';
                        }
                        else if($key=='submit') null;
                        else $return = 'invalid_field';
                    }
                    if(strlen($value)>0 && $key!=='submit') $bleached[$key]=htmlspecialchars($value);
                }
                $return == '' ? $return='all_good' : null;

                switch($return){
                    case 'all_good':
                        $informations_return = "Vos informations ont bien été mises à jour.<a href='profil'>Retour</a>";
                        $user->updateInformations($bleached);
                        break;
                    case 'invalid_bio':
                        $informations_return = "Il y a eut une erreur dans votre bio. Veuillez <a href='informations'>Réessayer</a>.";
                        break;
                    case 'invalid_location':
                        $informations_return = "Il y a eut une erreur dans votre pays ou ville. Veuillez <a href='informations'>Réessayer</a>.";
                        break;
                    case 'invalid_name':
                        $informations_return = "Il y a eut une erreur dans votre nom ou prénom. Veuillez <a href='informations'>Réessayer</a>.";
                        break;
                    case 'invalid_phone':
                        $informations_return = "Il y a eut une erreur dans votre numéro de téléphone. Veuillez <a href='informations'>Réessayer</a>.";
                        break;
                    case 'invalid_birthdate':
                        $informations_return = "Il y a eut une erreur dans votre date de naissance. Veuillez <a href='informations'>Réessayer</a>.";
                        break;
                    case 'invalid_field':
                    default:
                        $informations_return = "Il y a eut une erreur dans le traitement de vos données.<br><a href='informations'>Réessayer</a>";
                        break;
                }
            }
            include VIEW . 'user/informations.php';
        }
        else{
            $error = ['origin' => 'informations', 'message' => 'Vous devez vous connecter pour afficher cette page.'];
            include VIEW . 'error.php';
        }
        
        $this->main[] = ob_get_clean();
        $this->render();
    }
}