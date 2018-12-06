<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0";>
    <title> Aufgabe5 </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
</head>
<body>
  <div class="container">
    <h1> Anmeldung </h1>

      <?php
        if($_POST) {

          $vorname = filter_var($_POST['vorname'], FILTER_SANITIZE_STRING);
          $nachname = filter_var($_POST['nachname'], FILTER_SANITIZE_STRING);
          $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
          $studiengang = filter_var($_POST['studiengang'],FILTER_SANITIZE_STRING);

          $fehler = false;
          if(!$vorname || !$nachname || !$email || !$studiengang) $fehler=true;

          if(!$fehler)
          {
            echo "<p> Herzlichen Dank ".$vorname." ".$nachname." vom Studiengang ".$studiengang." !<br/>
            Wir haben eine E-Mail an ".$email." gesendet. <br/>
            <a href='./aufgabe7.php'>Zurück</a>
            </p>
            ";
          }
      }
      if(($_POST && $fehler) || empty($_POST)) :
        ?>

    <form action="./aufgabe7.php" method="post" autocomplete="off">
    <div class="form-group row">
        <label for="vorname" class="col-3"> Vorname : </label>
        <?php
          if(isset($vorname)&& !$vorname)
          {
            echo "
            <input type='text' name='vorname' placeholder='Vorname' class='form-control col-9 is-invalid'>
            <div class='invalid-feedback'>
            Bitte Vornamen eintragen!
            </div>
            ";
          }
          else
          {
            echo "
            <input type='text' name='vorname' placeholder='Vorname' class='form-control col-9'>
            ";
          }
         ?>

    </div>

    <div class="form-group row">
        <label for="nachname" class="col-3"> Nachname : </label>
        <input type="text" name="nachname" placeholder="Nachname" class="form-control col-9">
    </div>

    <div class="form-group row">
        <label for="email" class="col-3"> E-Mail : </label>
        <input type="email" name="email" placeholder="E-Mail" autocomplete="off" class="form-control col-9">
    </div>

  <div class="form-group row">
    <label for="studiengang" class="col-3"> Studiengang : </label>
    <select name="studiengang" class="form-control col-9">
      <option value="FIW">Informatik und Wirtschaft </option>
      <option value="AI">Angewandte Informatik </option>
      <option value="IMI">Internationale Medieninformatik </option>
    </select>
  </div>

  <div class="form-group row">
      <label for="password" class="col-3"> Passwort : </label>
      <input type="password" name="password" placeholder="Passwort" autocomplete="new-password" class="form-control col-9">
  </div>

      <div class="form-group row">
        <button type="submit" class="btn btn-primary"> Anmelden </button>
      </div>

    </form>
    <?php
      endif;
     ?>

  </div>
  </body>
  </html>
