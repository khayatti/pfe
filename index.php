<?php
@session_start();
require('controller/action.php');
$user = new Users();
$patt = new Patient();
$rendez_vous = new Rendez_vous();
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'login') {
        require('views/login.php');
    } elseif ($_GET['action'] == 'valide') {
        $user->connect($_POST['email'], $_POST['mtp']);
    } elseif ($_GET['action'] == 'doctor') {
        testSession("doctor");
        require('views/doctor.php');
    } elseif ($_GET['action'] == 'patient') {
        testSession("patient");
        require('views/patient.php');
    } elseif ($_GET['action'] == 'patient/reserver') {
        testSession("patient");
        $rendez_vous->addReservation($_POST['prenom'],$_POST['nom'],$_SESSION['email'],$_POST['mobile'],$_POST['CIN'],$_POST['drv'],$_POST['trv'],$_POST['age'],$_POST['sang'],$_POST['sexe']);
        header('Location:/projet/patient');
    } elseif ($_GET['action'] == 'inscription') {
        require('views/inscription.php');
    } elseif ($_GET['action'] == 'ins') {
        $user->adduser($_POST['nom'], $_POST['prenom'], $_POST['mobile'], $_POST['email'], $_POST['mtp'], $_POST['adresse'], $_FILES['photo']['tmp_name'], $_FILES['photo']['name'], $_POST['type']);
        $patt->addpatient($_POST['email'], $_POST['CIN']);
    } elseif ($_GET['action'] == 'error') {
        require('views/login.php');
        include('views/error.php');
    } elseif ($_GET['action'] == 'errorins') {
        require('views/inscription.php');
        include('views/errorins.php');
    } elseif ($_GET['action'] == 'ChangePassword') {
        $user->changePassword($_SESSION['email'], $_SESSION['id'], $_POST['old'], $_POST['new']);
        include('views/login.php');
    } elseif ($_GET['action'] == 'errorPassword') {
        include('views/errorPassword.php');
        include('views/patient.php');
    } elseif ($_GET['action'] == 'logout') {
        delSession();
        header('Location:home');
    } elseif ($_GET['action'] == 'home') {
        include('views/home.php');
    } elseif ($_GET['action'] == 'error404') {
        include('views/404.php');
    } else {
        header('Location:error404');
    }
} else {
    header('Location:home');
}
