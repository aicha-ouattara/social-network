<?php

class Informations extends View{
    
    protected $pageTitle = 'Informations';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        /**
         * Replace all echos with specifics views
         */
        if(isset($user) && $user){
            ob_start();
            if(isset($_POST) && $_POST){
                $return = '';
                $bleached=[];
                foreach($_POST as $key=>$value){
                    if($return !== '') break;
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
                    if(strlen($value)>0 && $key!=='submit') $bleached[$key]=htmlspecialchars($value);
                }
                $return == '' ? $return='all_good' : null;

                switch($return){
                    case 'all_good':
                        echo "Vos informations ont bien été mises à jour.";
                        $user->updateInformations($bleached);
                        break;
                    case 'invalid_bio':
                        echo "Il y a eut une erreur dans votre bio. Veuillez réessayer.";
                        break;
                    case 'invalid_location':
                        echo "Il y a eut une erreur dans votre pays ou ville. Veuillez réessayer.";
                        break;
                    case 'invalid_name':
                        echo "Il y a eut une erreur dans votre nom ou prénom. Veuillez réessayer.";
                        break;
                    case 'invalid_phone':
                        echo "Il y a eut une erreur dans votre numéro de téléphone. Veuillez réessayer.";
                        break;
                    case 'invalid_birthdate':
                        echo "Il y a eut une erreur dans votre date de naissance. Veuillez réessayer.";
                        break;
                    case 'invalid_field':
                    default:
                        echo "Il y a eut une erreur dans le traitement de vos données.";
                        break;
                }
            }
            include VIEW . 'user/informations.php';
            $this->main[] = ob_get_clean();
        }
        else $this->main[] = 'Vous devez vous connecter pour afficher cette page.';

        $this->render();
    }
}