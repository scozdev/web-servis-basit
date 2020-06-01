<?php
require 'db.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user_mail = $_POST['user_mail'] ? $_POST['user_mail'] : '';
    $user_pass = $_POST['user_pass'] ? $_POST['user_pass'] : '';


    $query = $db->prepare('SELECT * FROM users WHERE user_mail = :usermail and user_pass = :userpass');
    $query->execute([
        'usermail' => $user_mail,
        'userpass' => $user_pass
    ]);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    class User
    {
        public $id;
        public $username;
        public $mail;
        public $pass;
        public $text;
        public $isLogin;
    }
    $user = new User();



    if (empty($user_mail) || empty($user_pass)) {
        $user->text = 'Bos alan birakilamaz.';
        $user->isLogin = false;
        $user->id = null;
        $user->username = null;
        $user->mail = null;
        $user->pass = null;
        echo json_encode($user);
    } else if ($row) {
        $user->text = 'Giris basarili.';
        $user->isLogin = true;
        $user->id = $row['user_id'];
        $user->username =  $row['user_name'];
        $user->mail =  $row['user_mail'];
        $user->pass =  $row['user_pass'];
        echo json_encode($user);
    } else {
        $user->text = 'Kullanici adi veya sifre yanlis.';
        $user->isLogin = false;
        $user->id = null;
        $user->username = null;
        $user->mail = null;
        $user->pass = null;
        echo json_encode($user);
    }
}
