<?php
session_start();
$_SESSION['logged_user_id'] = 1; // TEMP
// print_r($_POST);
// print_r($_FILES);


    if (isset($_POST) && !empty ($_POST['object']) && !empty($_POST['message'])){
        $_SESSION['logged_user_id'] ? $user_id = $_SESSION['logged_user_id'] : $user_id = "";
        !empty($_POST['first_name']) ? $first_name = $_POST['first_name'] : $first_name = "";
        !empty($_POST['last_name']) ? $last_name = $_POST['last_name'] : $last_name = "";
        !empty($_POST['email']) ? $email = $_POST['email'] : $email = "";
        !empty($_POST['phone']) ? $phone = $_POST['phone'] : $phone = "";
        !empty($_POST['order']) ? $order_id = $_POST['order'] : $order_id = "0";
        $object = $_POST['object'];
        $message = $_POST['message'];
        $attachment = "";

        !empty($_FILES) ? $image_url = strip_tags($_FILES['attachment']['name']) : $image_url = "null";

        //GESTION DE L'IMAGE
        if($image_url !== "null"){
        $uploadDir = 'tickets/attachments/'; // DOSSIER OU L'ON STOCKERA LES PIECES JOINTES
        $imageFileType = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION)); // EXTENSION DU FICHIER UPLOADE
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'bmp'); // EXTENSIONS AUTORISEES
    
        // Check if the file is an allowed image type
        if(in_array($imageFileType, $allowedTypes)){ // SI L'EXTENSION DU FICHIER UPLOADE EST AUTORISEE
            $newFileName = 'Attachement_' . time() . '.' . $imageFileType;
            $image_filename = $uploadDir . $newFileName;
            $attachment = $image_filename;
            move_uploaded_file($_FILES['attachment']['tmp_name'], $image_filename); // ON PUSH L'IMAGE DANS LE DOSSIER
            }
        else{
            echo 'extension d\'image incorrecte'; // ERREUR SESSION ICI
            $_SESSION['info_message'] = "Extension d'image incorrecte";
        }
    }
         // CONNEXION + MESSAGE TEMPORAIRE
         require_once('php_sql/db_connect.php');

        $sql = "INSERT INTO tickets (user_id, last_name, first_name, email, phone, order_id, object, message, attachment)
                        VALUES (:user_id, :last_name, :first_name, :email, :phone, :order_id, :object, :message, :attachment)";

                $query = $db->prepare($sql);
                $query->bindValue(':user_id', $user_id);
                $query->bindValue(':last_name', $last_name);
                $query->bindValue(':first_name', $first_name);
                $query->bindValue(':email', $email);
                $query->bindValue(':phone', $phone);
                $query->bindValue(':order_id', $order_id);
                $query->bindValue(':object', $object);
                $query->bindValue(':message', $message);
                $query->bindValue(':attachment', $attachment);                
                $query->execute();    
        

    }
    else{
        $_SESSION['info_message'] = "Le formulaire n'a pas été rempli correctement.";
        header('Location: test_create_ticket.php'); // Redirection vers la page de contact
    }
?>