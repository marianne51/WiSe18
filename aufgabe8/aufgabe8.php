<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <title>Formular</title>
   <link rel="stylesheet" href="bootstrap.min.css">
   <link rel="stylesheet" href="styles.css">
   <?php

   /* in der folgenden Datei steht mein Passwort für den MySQl-Server
    *  $password = 'meinPasswort';
    *
    */
   	require_once 'nichtinzip/passwd.inc.php'; //'../nichtinzip/passwd.inc.php'
   	require_once('DB.php');

   	/* hier wird ein neues Objekt von DB erzeugt
   	 * erster Parameter ist der Name Ihrer Datenbank (auf dem Studi-Server _IhreMatrNr__mockupdatadb
   	 * , lokal wahrscheinlich nur mockupdatadb
   	 * zweiter Parameter ist der MySql-Server (Studi-Server db.f4.htw-berlin.de:3306
   	 * , lokal wahrscheinlich localhost
   	 * dritter Parameter ist Ihr Nutzername (vom MySQL-Server) (Studi-Server Ihr FB4-Account
   	 * , lokal wahrscheinlich root
   	 * vierter Parameter ist Ihr Passwort (ich habe mein Passwort als Wert der Variablen $password
   	 * in der Datei passwd.inc.pwd abgelegt (siehe oben)
   	 */
   	$dbh = new DB('_s0564891__mockupdatadb', 'db.f4.htw-berlin.de:3306', 's0564891', $password);

   	/* die folgende Funktion ist nur eine Hilfsfunktion zum Debuggen
   	 * auf der Konsole in den Entwicklertools Ihres Browsers erscheint
   	 * der als String übergebene Text
   	 * die Funktion kann auch gelöscht werden
   	 */
   function debug_to_console( $data ) {

       if ( is_array( $data ) )
           $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
       else
           $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

       echo $output;
   }
   ?>
</head>
<body>
	<?php
	   $form_header = 'Teilnehmerin hinzufügen';

	   if ($_GET) {
            /*
             * es empfiehlt sich, an Ihre URL bei Absenden des Formulars ein "command" als Schlüssel anzuhängen,
             * welcher die Werte "edit" oder "delete" annehmen kann, je nachdem, ob Sie einen Datensatz
             * ändern oder löschen möchten
             * An den einzelnen "Karteikarten" erscheinen edit- und delete-"Buttons" - s.u.
             */
             $command = $_GET['command'];
             $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT); //eventuell FILTER_SANITIZE_STRING

             if($command=='delete')
             {
               $dbh->delete($id);
               $message='Teilnehmerin gelöscht.';
             }
             if($command=='edit')
             {
               $teilnehmerin = $dbh->get($id);
               $form_header = 'Eintrag bearbeiten.';
             }
	   }

	   elseif ($_POST) {
            /*
             * hier werden die über das Formular gesendeten Daten ausgewertet
             * 2 Fälle: wird die id mitgesendet, dienen die übersendeten Daten der Änderung des
             * entsprechenden Datensatzes
             * wird die id nicht mitgeliefert, dienen die Daten dem Einfügen eines neuen Datensatzes
             * in die Datenbank
             */
             $vorname = filter_var($_POST['vorname'], FILTER_SANITIZE_STRING);
             $nachname = filter_var($_POST['nachname'], FILTER_SANITIZE_STRING);
             $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
             $ip = filter_var($_POST['ip'], FILTER_SANITIZE_STRING);


             if(isset($_POST['id'])) $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

             if(isset($id)) //hier sind wir im editieren
             {
               $dbh->edit(array($vorname, $nachname, $email, $ip, $id));
               $message = 'Eintrag geändert.';
             }
             else // hier hinzufügen / Anlegen
             {
               $dbh->add(array($vorname, $nachname, $email, $ip));
               $message = 'Teilnehmerin hinzugefügt.';
             }

	   }
     //$dbh->add(array("Max", "Muster","m@web.de", "123"));
     //$dbh->delete(51);
     //$dbh->edit(array("Jan","Juster","jan@web.de", "12344", "51"));
  	 $teilnehmerinnen = $dbh->all(); //immer machen
	?>
   <div class="container">
      <div class="panel panel-default">

         <div class="panel-heading">
            <h3 class="panel-title"><?= $form_header ?></h3>
         </div>

         <div class="panel-body">

            <?php if (isset($message)) : ?>
               <div class="alert alert-success">
                  <?= $message ?>
               </div>
            <?php endif; ?>

            <?php if (isset($command) && $command == 'edit') : ?>

            <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
             <!--
                  dies ist das Formular für die Änderung eines Datensatzes
                  es beinhaltet 4 einzeilige Textfelder: für Vornmae, Name, E-Mail-Adresse und IP-Nummer
                  beachten Sie: das Formular soll auch die id weitergeben (hidden-Textfeld)
                  beachten Sie: die Textfelder sind mit dem Datensatz, der editiert werden soll, vorausgefüllt
             -->
              <input class="form-control" type="text" name="vorname" value="<?php echo $teilnehmerin['vorname']; ?>" />
              <input class="form-control" type="text" name="nachname" value="<?php echo $teilnehmerin['nachname']; ?>" />
              <input class="form-control" type="text" name="email" value="<?php echo $teilnehmerin['email']; ?>" />
              <input class="form-control" type="text" name="ip" value="<?php echo $teilnehmerin['ipnr']; ?>" />
              <input type="hidden" name="id" value="<?php echo $teilnehmerin['ipnr']; ?>" />
              <button type="submit" class="btn btn-primary btn-block"> Aktualisieren </button>
            </form>

            <?php else : ?>
           	<div class="row">
           		<div class="col-xs-12">
            		<form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <!--
                             dies ist das Formular für das Anlegen eines neuen Datensatzes
                             es beinhaltet 4 einzeilige Textfelder: für Vornmae, Name, E-Mail-Adresse und IP-Nummer
                             keine id - diese wird von der Datenbank selbständig erzeugt (auto inkrement)
                        -->
                          <input class="form-control" type="text" name="vorname" placeholder="Vorname" />
                          <input class="form-control" type="text" name="nachname" placeholder="Nachname" />
                          <input class="form-control" type="text" name="email" placeholder="E-Mail-Adresse" />
                          <input class="form-control" type="text" name="ip" placeholder="IP-Adresse" />
                          <button type="submit" class="btn btn-primary btn-block"> Anlegen </button>
            		</form>
               	 </div>
             </div>
         <?php endif; ?>

         </div> <!-- / .panel-body -->
      </div> <!-- / .panel -->

      <div class="row">

         <?php
            if (!sizeof($teilnehmerinnen)) {
               echo '<div class="alert alert-info">Es sind keine Studentinnen angemeldet!</div>';
            }
            else {
               foreach ($teilnehmerinnen as $teilnehmerin)
               {
                  echo
                  '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                     <div class="thumbnail">
                        <p> '.$teilnehmerin["vorname"].' </p>
      					        <h4> '.$teilnehmerin["nachname"].' </h4>
      		 			        <p> '.$teilnehmerin["email"].' </p>
      					        <p> '.$teilnehmerin["ipnr"].' </p>
                        <div class="buttons-edit">
                           <a class="btn btn-default btn-sm" href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?command=edit&id='.$teilnehmerin["id"].'">Edit</a>
                           <a class="btn btn-default btn-sm" href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?command=delete&id='.$teilnehmerin["id"].'">Delete</a>
                        </div>
                     </div>
                  </div>';
               }
            }
         ?>

      </div> <!-- / list-group -->
   </div> <!-- / .container -->
</body>
</html>
