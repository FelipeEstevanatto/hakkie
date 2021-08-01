<?php

include('config.php');
require('../database/connect.php');
require('../php/functions.php');

if(isset($_POST['id_token'])) {

    $id_token = cleanString($_POST['id_token']);
 
    $payload = $google_client->verifyIdToken($id_token);

    // Retorna todas as informações do usuário em formato JSON
    // header('location: https://oauth2.googleapis.com/tokeninfo?id_token='.$id_token);
       
    if ($payload) {

        $json = file_get_contents("https://oauth2.googleapis.com/tokeninfo?id_token=".$id_token);
        $data = json_decode($json);
        $acess_token = $google_client->fetchAccessTokenWithAuthCode($id_token);
        
        $google_client->setAccessToken($acess_token);

        //$gAuth = new Google_Service_Oauth($google_client);

        // Get profile info
        $email =  $data->email;
        $name =  $data->name;
        //var_dump($data);exit();
    }

} else {
    echo "Somethine went really wrong";
}
    
