<?php
  $firstname = $name = $email = $phone = $message ="";
  $firstnameError = $nameError = $emailError = $phoneError = $messageError ="";
  $isSucces = false;
  $emailTo = "lebel.olivier@wanadoo.fr";

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $firstname = verifyInput($_POST["firstname"]);
    $name = verifyInput($_POST["name"]);
    $email = verifyInput($_POST["email"]);
    $phone = verifyInput($_POST["phone"]);
    $message = verifyInput($_POST["message"]);
    $isSucces = true;
    $emailText = "";

    if(empty($firstname))
    {
      $firstnameError = "Entrer votre prenom.";
      $isSucces = false;
    }
    else $emailText .= "Prénom : $firstname\n";

    if(empty($name))
    {
      $nameError = "Entrer votre nom.";
      $isSucces = false;
    }
    else $emailText .= "Nom : $name\n";

    if(!isEmail($email))
    {
      $emailError = "Entrer un email valide.";
      $isSucces = false;
    }
    else $emailText .= "Email : $email\n";

    if(!isPhone($phone))
    {
      $phoneError = "Entrer un numéro valide (9 chiffres après le 0 ou +33)";
      $isSucces = false;
    }
    else $emailText .= "Téléphone : $phone\n";

    if(empty($message))
    {
      $messageError = "Entrer votre message.";
      $isSucces = false;
    }
    else $emailText .= "Message : $message\n";

    if($isSucces){
      //envoie email
      $headers = "From: $firstname $name <$email>\r\nReply-To: $email";
      mail($emailTo, "Un message de votre site", $emailText, $headers);
      $firstname = $name = $email = $phone = $message ="";
    }
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

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contactez moi</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
      crossorigin="anonymous"
    />
    <link
      href="http://fonts.googleapis.com/css?family=lato"
      rel="stylesheet"
      type="text/css"
    />
    <link rel="stylesheet" href="css/style.css" />
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
      integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
      crossorigin="anonymous"
    ></script>
  </head>

  <body>
    <div class="container">
      <div class="divider"></div>

      <div class="heading">
        <h2>Contactez moi</h2>
      </div>

      <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
          <form id="contact-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" role="form">
            <div class="row">
              <div class="col-md-6">
                <label for="firstname"
                  >Prénom <span class="blue"> *</span>
                </label>
                <input
                  type="text"
                  id="firstname"
                  name="firstname"
                  class="form-control"
                  placeholder="Votre prénom"
                  value ="<?php echo $firstname; ?>"                                   
                  required
                />
                <p class="comments text-danger"><?php echo $firstnameError; ?></p>
              </div>

              <div class="col-md-6">
                <label for="name">Nom <span class="blue"> *</span> </label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  class="form-control"
                  placeholder="Votre nom"
                  value ="<?php echo $name; ?>"
                  required
                />
                <p class="comments text-danger"><?php echo $nameError; ?></p>
              </div>

              <div class="col-md-6">
                <label for="email">Email <span class="blue"> *</span> </label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="form-control"
                  placeholder="Votre email"
                  value ="<?php echo $email; ?>"
                  required
                />
                <p class="comments text-danger"><?php echo $emailError; ?></p>
              </div>

              <div class="col-md-6">
                <label for="phone">Téléphone </label>
                <input
                  type="tel"
                  id="phone"
                  name="phone"
                  class="form-control"
                  placeholder="Votre téléphone"
                  value ="<?php echo $phone; ?>"
                />
                <p class="comments text-danger"><?php echo $phoneError; ?></p>
              </div>

              <div class="col-md-12">
                <label for="message"
                  >Message <span class="blue"> *</span>
                </label>
                <textarea
                  name="message"
                  id="message"
                  rows="4"
                  class="form-control"
                  placeholder="Votre message"
                  value ="<?php echo $message; ?>"
                  required
                ></textarea>
                <p class="comments text-danger"><?php echo $messageError; ?></p>
              </div>

              <div class="col-md-12">
                <p class="blue font-weight-bold">
                  * Ces informations sont requises.
                </p>
              </div>

              <div class="col-md-12">
                <input
                  type="submit"
                  class="btn btn-warning font-weight-bold"
                  value="Envoyer"
                />
              </div>
            </div>
            <p class="thank-you" style="display:<?php if($isSucces)  echo 'block'; else echo 'none'; ?>">
              Votre message a bien été envoyé. Merci de m'avoir contacté !
              &#128512;
            </p>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
