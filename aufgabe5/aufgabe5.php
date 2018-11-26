<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--link href="../css/bootstrap.min.css" rel="stylesheet"-->
    <title> Aufgabe5 </title>
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/-->

    <link href="bootstrapROBIN.min.css" rel="stylesheet">
    <?php
    function zufzahl($max, $anzahl, $stellen)
    {
      for($i=1; $i<=$anzahl;$i++)
      {
        //$zzahl = rand(1,$max);
        //$gerundet1 = abschneiden($zzahl,1); //test
        // nicht über dok öffnen sondern mit localhost und dann die url --> mit dem pfad
        // lokal host heißt sie sind in httpdocs?
        //$gerundet2 = abschneiden($zzahl,2);
        //$gerundet3 = abschneiden($zzahl,3);
        //$stellen =
        // echo "$zzahl. " " .$gerundet1. " " .$gerundet2. " " .$gerundet3." <br/>; nur ein Test
        // zur not wenn Link nicht funktioniert dann den hier : <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        // https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css
        echo "<table class ='table table-striped'>";
        echo "<thead>
          	       <tr class='text-center'>
                   <th>Zufallszahl</th>";
                   for($j=1; $j<$stellen;$j++)
                   {
                     echo "<th>".$j. " gerundet </th>";
                   }
                   //<th> 1 gerndet </th>
                  // <th> 2 gerundet </th>
                   //<th> 3 gerundet </th>
        echo          "</tr>
                   </thead>
                   <tbody>";
        for($i=1;$i<=$anzahl;$i++)
        {
          $zzahl = rand(1,$max);
          //$gerundet1 = abschneiden($zzahl,1); //test
          //$gerundet2 = abschneiden($zzahl,2);
          //$gerundet3 = abschneiden($zzahl,3);
          if($zzahl<5000)
          {
            echo "<tr class='text-center table-secondary' style='background-color: #ea917b; opacity:0.9'>";
          }
          else {
            echo "<tr class ='text-center table-success' style='background-color: #99caea;opacity:0.9'>";
          }
          //echo"<tr class='text-center'>";
          //echo"td>".$zzahl. "</td>";

          for($j=1; $j<=$stellen;$j++)
          {
            echo "<td>".abschneiden($zzahl, $j)."</td>";
          }
          //echo "<td>".$gerundet1. " </td>";
          //echo "<td>".$gerundet2. " </td>";
          //echo "<td>".$gerundet3. " </td>";
          echo"</tr>";
        }
        echo "</tbody>";

      }
    }
    function abschneiden($zahl,$stellen=2)
    {
      $base = pow(10,$stellen);
      return $zahl - ($zahl % $base);
    }
    ?>
    <title></title>
  </head>
  <body>
    <h1 class="text-primary" style="font-weight: bold; font-family:'Arial'">Zufallszahlen</h1>
    <button class="btn btn-danger" type="button">I love FOOD </button>
    <div>
      <?php zufzahl(10000,50,4) ?>
    </div>
  </body>
</html>
