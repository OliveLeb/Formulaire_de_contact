<?php

  $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "",
   "message" => "", "firstnameError" => "", "nameError" => "",
   "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);
  $emailTo = "lebel.olivier@wanadoo.fr";

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $array["firstname"] = verifyInput($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["email"] = verifyInput($_POST["email"]);
    $array["phone"] = verifyInput($_POST["phone"]);
    $array["message"] = verifyInput($_POST["message"]);
    $array["isSuccess"] = true;
    $emailText = "";

    if(empty($array["firstname"]))
    {
      $array["firstnameError"] = "Entrer votre prenom.";
      $array["isSucces"] = false;
    }
    else $emailText .= "Prénom : {$array["firstname"]}\n";

    if(empty($array["name"]))
    {
      $array["nameError"] = "Entrer votre nom.";
      $array["isSuccess"] = false;
    }
    else $emailText .= "Nom : {$array["name"]}\n";

    if(!isEmail($array["email"]))
    {
      $array["emailError"] = "Entrer un email valide.";
      $array["isSuccess"] = false;
    }
    else $emailText .= "Email : {$array["email"]}\n";

    if(!isPhone($array["phone"]))
    {
      $array["phoneError"] = "Entrer un numéro valide (9 chiffres après le 0 ou +33)";
      $array["isSuccess"] = false;
    }
    else $emailText .= "Téléphone : {$array["phone"]}\n";

    if(empty($array["message"]))
    {
      $array["messageError"] = "Entrer votre message.";
      $array["isSuccess"] = false;
    }
    else $emailText .= "Message : {$array["message"]}\n";

    if($array["isSuccess"]){
      //envoie email
      // changer le sendmail_path dans config php.ini
      $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}";
      mail($emailTo, "Un message de votre site", $emailText, $headers);
    }
    
    echo json_encode($array);
  }

function isEmail($var)
{
  return filter_var($var, FILTER_VALIDATE_EMAIL);
}

function isPhone($var)
{
  //return preg_match("/^[0-9]*$/", $var);
  return preg_match("#^((0|\+33)[1-9]([0-9]{8}))?$#", $var);
  // commence par 0 ou +33 suivi d'un chiffre >0 puis 8 autres >=0. Soit n° complet soit vide.
  
}

  function verifyInput($var)
  {
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
  }
?>