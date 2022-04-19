<?php
    $errors = [];
    
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uploadDir = 'public/uploads/';

    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

    $authorizedExtensions = ['jpg','gif','png', 'webp'];

    $maxFileSize = 1000000;

    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg, Gif, Webp ou Png !';
    }

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    if (empty($errors)) {
        $fileInfo = pathinfo($_FILES["avatar"]["name"]);
        move_uploaded_file(
            $_FILES["avatar"]["tmp_name"],
            "public/uploads/" . uniqid() . '.' . $fileInfo['extension']
        );
        header('Location: /index.php');
    }
}
    foreach ($errors as $error) {
        echo $error;
    }
?>

<form method="post" enctype="multipart/form-data">

    <label for="imageUpload">Upload an profile image</label>    
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Send</button>

</form>