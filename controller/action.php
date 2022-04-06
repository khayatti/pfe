<?php
@session_start();
require("models/model.php");
require("session.php");
class Users
{
   public function __constract()
   {
   }

   public function start()
   {
      require('views/login.php');
   }
   public function connect($email, $mtp)
   {
      $mtp = md5($mtp);
      $res = R::find('users', "email=? AND mtp=?", [$email, $mtp]);
      if (count($res) == 0) {
         header('Location:error');
      } else {
         $info = R::findOne("users", "email=?", [$email]);
         $_SESSION['email'] = $info['email'];
         $_SESSION['nom'] = $info['nom'];
         $_SESSION['mobile'] = $info['mobile'];
         $_SESSION['prenom'] = $info['prenom'];
         $_SESSION['CIN'] = $info['CIN'];
         $_SESSION['id'] = $info['id'];
         $_SESSION['photo'] = $info['photo'];
         $type = type($email);
         $_SESSION['type'] = $type;
         if ($type == 'doctor') {
            header('Location:doctor');
         } elseif ($type == 'patient') {
            header('Location:patient');
         }
      }
   }
   public function adduser($nom, $prenom, $mobile, $email, $mtp, $adress, $tmp, $photo, $type)
   {
      $mtp = md5($mtp);
      $exist = R::find('users', "email=?", [$email]);;
      if (count($exist) !== 0) {
         header('Location:errorins');
      } else {
         $path = 'views/profile/' . $photo;
         move_uploaded_file($tmp, $path);
         $user = R::dispense('users');
         $user->nom = $nom;
         $user->prenom = $prenom;
         $user->mobile = $mobile;
         $user->email = $email;
         $user->mtp = $mtp;
         $user->adress = $adress;
         $user->photo = $photo;
         $user->type = $type;
         $user->datecreation = Date('Y-m-d');
         R::store($user);
         header('Location:login');
      }
   }


   public function changePassword($email, $id, $password, $newPasword)
   {
      $exist = exist($email, $password);
      if ($exist == true) {
         $user = R::load('users', $id);
         $user->mtp = md5($newPasword);
         R::store($user);
      } else {
         header("Location:errorPassword");
      }
   }
}

class Patient
{
   function addpatient($email, $CIN)
   {

      $patt = R::dispense('patient');
      $patt->email = $email;
      $patt->CIN = $CIN;

      R::store($patt);
   }
}
class Rendez_vous
{
   function addReservation($prenom, $nom, $email, $mobile, $CIN, $drv, $trv, $age, $sang, $sexe)
   {
      $rv = R::dispense('rendez');
      $rv->nom_complet = $prenom . ' ' . $nom;
      $rv->email = $email;
      $rv->tel = $mobile;
      $rv->CIN = $CIN;
      $rv->date_rendez_vous = $drv;
      $rv->time_rendez_vous = $trv;
      $rv->age = $age;
      $rv->sang = $sang;
      $rv->sexe = $sexe;
      $rv->date_reservation = Date('Y-m-d');
      $rv->etat = "requested";
      R::store($rv);
   }
}
