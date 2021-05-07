<?php

    $cookie_options = array(
        'expires' => time() + 36000,
        'path' => '/',
        'domain' => 'localhost',
        'secure' => true,
        'httponly' => false,
        'samesite' => 'Strict'
    );

    if(isset($_COOKIE['authtoken']) && $_COOKIE['authtoken']){
        $session = new Session($_COOKIE['authtoken']);
        switch($session->authenticate($_COOKIE['authtoken'])){
            case 'validtoken':
                setcookie('authtoken', $_COOKIE['authtoken'], $cookie_options);
                /**
                 * Create user with all its data ( in session ? )
                 */
                $user = new User(['authtoken' => $_COOKIE['authtoken']]);
                $authorize=1;
                $user = $user->getProfile();
                break;
            case 'invalidtoken':
            default:
                setcookie('authtoken', '', -1, '/');
                break;
        }
    }