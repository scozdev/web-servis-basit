<?php
require 'db.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $user_name = $_POST['user_name'] ? $_POST['user_name'] : '';
    $user_mail = $_POST['user_mail'] ? $_POST['user_mail'] : '';
    $user_pass = $_POST['user_pass'] ? $_POST['user_pass'] : '';
    $user_confirmation = rand(0, 1000) . rand(0, 1000);
    $user_condition = 0;

    $userControl = $db->query("select * from users where user_name='$user_name' or user_mail='$user_mail'")->rowCount();

    class User
    {
        public $text;
        public $isRegister;
    }
    $user = new User();



    if (empty($user_name) || empty($user_mail) || empty($user_pass)) {
        $user->text = 'Bos alan birakilamaz.';
        $user->isRegister = false;
        echo json_encode($user);
    } else if ($userControl) {
        $user->text = 'Kullanici zaten var.';
        $user->isRegister = false;
        echo json_encode($user);
    } else {

        $kaydet = $db->prepare("INSERT INTO users SET
		user_name=:user_name,
		user_mail=:user_mail,
		user_pass=:user_pass,
		user_confirmation=:user_confirmation,
		user_condition=:user_condition
		");
        $insert = $kaydet->execute(array(
            'user_name' => $user_name,
            'user_mail' => $user_mail,
            'user_pass' => $user_pass,
            'user_confirmation' => $user_confirmation,
            'user_condition' => $user_condition
        ));


        if ($insert) {
            $user->text = 'Kayit basarili.';
            $user->isRegister = true;
            echo json_encode($user);
        } else {
            $user->text = 'Kayit basarisiz .';
            $user->isRegister = false;
            echo json_encode($user);
        }
    }
}
