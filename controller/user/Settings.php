<?php

class Settings extends View{
    
    protected $pageTitle = 'Paramètres';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        // If the user is connected
        if(isset($user) && $user){
            if(intval($user->getHis('id_settings')) == 0){
                $user->createSettings();
            }
            ob_start();
            if(isset($_POST) && $_POST){
                $userpath = ROOT . 'storage/user' . $user->getHis('id');
                // Create all needed folders
                !file_exists($userpath) ? mkdir($userpath, 0777, true) : null;
                !file_exists($userpath . '/pictures') ? mkdir($userpath . '/pictures', 0777, true) : null;
                !file_exists($userpath . '/backgrounds') ? mkdir($userpath . '/backgrounds', 0777, true) : null;

                // If the user is uploading a profile picture
                if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK){
                    if($_FILES['profile_picture']['size'] < 2000000){
                        $temp_path = $_FILES['profile_picture']['tmp_name'];
                        $picture_name = $_FILES['profile_picture']['name'];
                        $picture_name_split = explode(".", $picture_name);
                        $extension = strtolower(end($picture_name_split));
                        if(in_array($extension, ['jpg', 'jpeg', 'bmp', 'gif', 'png'])){
                            $picture_hash_name = md5(time() . $_FILES['profile_picture']['name']) . '.' . $extension;
                            $dir = $userpath . "/pictures/";
                            $path = $dir . $picture_hash_name;
                            if(move_uploaded_file($temp_path, $path)){
                                $path_split = explode("storage", $path);
                                $dbpath = 'storage' . $path_split[1];
                                $user->setProfile('picture', $dbpath);
                                $settings_return = "Votre image a bien été téléchargée.";
                            }
                            else $settings_return = "Une erreur est survenue pendant le transfert du fichier. Veuillez réessayer.";
                        }
                        else $settings_return = "Le type de fichier n'est pas valide. Seules les images au format jpg/jpeg, bmp, gif et png sont acceptées.";
                    }
                    else $settings_return = "Le fichier est trop volumineux. La taille maximale est de 2mo.";
                }
                // Else if the user is uploading a background picture
                else if(isset($_FILES['profile_background']) && $_FILES['profile_background']['error'] === UPLOAD_ERR_OK){
                    if($_FILES['profile_background']['size'] < 2000000){
                        $temp_path = $_FILES['profile_background']['tmp_name'];
                        $picture_name = $_FILES['profile_background']['name'];
                        $picture_name_split = explode(".", $picture_name);
                        $extension = strtolower(end($picture_name_split));
                        if(in_array($extension, ['jpg', 'jpeg', 'bmp', 'gif', 'png'])){
                            $picture_hash_name = md5(time() . $_FILES['profile_background']['name']) . '.' . $extension;
                            $dir = $userpath . "/backgrounds/";
                            $path = $dir . $picture_hash_name;
                            if(move_uploaded_file($temp_path, $path)){
                                $path_split = explode("storage", $path);
                                $dbpath = 'storage' . $path_split[1];
                                $user->setProfile('background', $dbpath);
                                $settings_return = "Votre image a bien été téléchargée.";
                            }
                            else $settings_return = "Une erreur est survenue pendant le transfert du fichier. Veuillez réessayer.";
                        }
                        else $settings_return = "Le type de fichier n'est pas valide. Seules les images au format jpg/jpeg, bmp, gif et png sont acceptées.";
                    }
                    else $settings_return = "Le fichier est trop volumineux. La taille maximale est de 2mo.";
                }
                // Else if the user is deleting his profile picture or background
                else if(isset($_POST['delete_background']) && $_POST['delete_background'] == 1 || isset($_POST['delete_picture']) && $_POST['delete_picture'] == 1){
                    $image = str_replace('delete_', '', key($_POST));
                    $user->deleteImage($image);
                }
                // Else if the user is modifying his password
                else if(isset($_POST['modify_password']) && $_POST['modify_password']){
                    $reflection = new ReflectionClass('Register');
                    $register = $reflection->newInstanceWithoutConstructor();
                    if($register->verifyPwd($_POST['modify_password'])){
                        $user->setNewPassword($_POST['modify_password']);
                        $settings_return = "Le mot de passe a été modifié avec succès.";
                    }
                    else $settings_return = 
                                "Le mot de passe n'est pas assez fort. Pour rappel, il doit faire 8 caractères de long et contenir :<br>
                                Au moins 1 lettre majuscule<br>
                                Au moins 1 lettre minuscule<br>
                                Au moins 1 chiffre<br>
                                Au moins 1 caractère spécial";
                }
                // Else if the user is modifying his mail
                else if(isset($_POST['modify_mail']) && $_POST['modify_mail']){
                    if(filter_var($_POST['modify_mail'], FILTER_VALIDATE_EMAIL) && strpos($_POST['modify_mail'], '@laplateforme.io')){
                        if($user->updateMail($_POST['modify_mail'])){
                            $settings_return = "Votre adresse mail a bien été mise à jour. Un mail de confirmation vient de vous être envoyé.";
                        }
                        else $settings_return = "Cette adresse mail est déjà utilisée. Veuillez réessayer.";
                    }else $settings_return = "Cette adresse mail est invalide.";
                }
            }
            include VIEW . 'user/settings.php';
        }
        // Else if the user isn't connected
        else{
            $error = array('origin' => 'settings', 'message' => 'Vous devez vous connecter pour accéder à cette page.');
            include VIEW . 'error.php';
        }
        $this->main[] = ob_get_clean();
        $this->render();
    }
}