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
                else echo "Vous devez télécharger une image.";
            }
            include VIEW . 'user/settings.php';
            $this->main[] = ob_get_clean();
        }
        else $this->main[] = "Vous devez vous connecter.";

        $this->render();
    }
}