<?php

class Settings extends View{
    
    protected $pageTitle = 'Paramètres';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        /**
         * Replace all echos with specifics views
         */

        if(isset($user) && $user){
            if(intval($user->getHis('id_settings')) == 0){
                $user->createSettings();
            }
            ob_start();
            if(isset($_POST) && $_POST){
                if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK){
                    if($_FILES['profile_picture']['size'] < 2000000){
                        $temp_path = $_FILES['profile_picture']['tmp_name'];
                        $picture_name = $_FILES['profile_picture']['name'];
                        $picture_name_split = explode(".", $picture_name);
                        $extension = strtolower(end($picture_name_split));
                        if(in_array($extension, ['jpg', 'jpeg', 'bmp', 'gif', 'png'])){
                            $picture_hash_name = md5(time() . $_FILES['profile_picture']['name']) . '.' . $extension;
                            $dir = ROOT . '/storage/users/pictures/';
                            $path = $dir . $picture_hash_name;
                            if(move_uploaded_file($temp_path, $path)){
                                $path_split = explode("//", $path);
                                $dbpath = $path_split[1];
                                $user->setProfilePicture($dbpath);
                                echo "Votre image a bien été téléchargée.";
                            }
                            else echo "Une erreur est survenue pendant le transfert du fichier. Veuillez réessayer.";
                        }
                        else echo "Le type de fichier n'est pas valide. Seules les images au format jpg/jpeg, bmp, gif et png sont acceptées.";
                    }
                    else echo "Le fichier est trop volumineux. La taille maximale est de 2mo.";
                }
                else if(isset($_FILES['profile_background']) && $_FILES['profile_background']['error'] === UPLOAD_ERR_OK){
                    if($_FILES['profile_background']['size'] < 2000000){
                        $temp_path = $_FILES['profile_background']['tmp_name'];
                        $picture_name = $_FILES['profile_background']['name'];
                        $picture_name_split = explode(".", $picture_name);
                        $extension = strtolower(end($picture_name_split));
                        if(in_array($extension, ['jpg', 'jpeg', 'bmp', 'gif', 'png'])){
                            $picture_hash_name = md5(time() . $_FILES['profile_background']['name']) . '.' . $extension;
                            $dir = ROOT . '/storage/users/backgrounds/';
                            $path = $dir . $picture_hash_name;
                            if(move_uploaded_file($temp_path, $path)){
                                $path_split = explode("//", $path);
                                $dbpath = $path_split[1];
                                $user->setProfileBackground($dbpath);
                                echo "Votre image a bien été téléchargée.";
                            }
                            else echo "Une erreur est survenue pendant le transfert du fichier. Veuillez réessayer.";
                        }
                        else echo "Le type de fichier n'est pas valide. Seules les images au format jpg/jpeg, bmp, gif et png sont acceptées.";
                    }
                    else echo "Le fichier est trop volumineux. La taille maximale est de 2mo.";
                }
                else if(isset($_POST['modify_password']) && $_POST['modify_password']){
                    $reflection = new ReflectionClass('Register');
                    $register = $reflection->newInstanceWithoutConstructor();
                    if($register->verifyPwd($_POST['modify_password'])){
                        $user->setNewPassword($_POST['modify_password']);
                        echo "Le mot de passe a été modifié avec succès.";
                    }
                    else echo   "Le mot de passe n'est pas assez fort. Pour rappel, il doit faire 8 caractères de long et contenir :<br>
                                Au moins 1 lettre majuscule<br>
                                Au moins 1 lettre minuscule<br>
                                Au moins 1 chiffre<br>
                                Au moins 1 caractère spécial";
                }
                else if(isset($_POST['modify_mail']) && $_POST['modify_mail']){
                    if(filter_var($_POST['modify_mail'], FILTER_VALIDATE_EMAIL) && strpos($_POST['modify_mail'], '@laplateforme.io')){
                        if($user->updateMail($_POST['modify_mail'])){
                            echo "Votre adresse mail a bien été mise à jour. Un mail de confirmation vient de vous être envoyé.";
                        }
                        else echo "Cette adresse mail est déjà utilisée. Veuillez réessayer.";
                    }else echo "Cette adresse mail est invalide.";
                }
            }
            include VIEW . 'user/settings.php';
            $this->main[] = ob_get_clean();
        }
        else $this->main[] = "Vous devez vous connecter.";

        $this->render();
    }
}