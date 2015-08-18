<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>La 86ième  - St Joseph</title>

    <!-- General utility functions -->
    <?php include 'functions.php'; ?>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="lib/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="default.css" rel="stylesheet">

  </head>

  <body>

    <?php include 'nav.php'; ?>
    <div class="container">
    <h1>Bureau des Chefs</h1>
    <!-- <h2>Documents</h2>
    <form role="form" method="post" enctype="multipart/form-data" action="upload.php">
      <div class="form-group">
        <label for="userfile">Ajouter un document</label>
        <input type="file" id="userfile" name="userfile">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form> -->

    <?php
    if ($_GET["id"] != "") {
      $id = $_GET["id"];
      $event = getEvent($id);
      if ($event) {
        $name = $event["title"];
        $start = date("Y-m-d H:i",$event["start"]/1000);
        $end = date("Y-m-d H:i",$event["end"]/1000);
      }
    } else {
        $event = getEvent(-1);
        $id = $event["id"];
        $name = "";
        $start = "";
        $end = "";
    }
    if ($_POST["name"] == "") {
      echo "<h2>Ajouter une réunion</h2>";
    } elseif ($_POST["password"] != "Joseph86") {
      echo "<h2>Mauvais mot de passe</h2>";
    } elseif ($_POST["name"]!="" && addEvent($_POST)===false) {
      echo "<h2>Oups ! Une erreur d'analyse a été commise.</h2>";
    } else {
      echo "<h2>Le nouvel événement à bien été ajouté</h2>";
    }
    ?>

    <form role="form" method="post">
      <div class="form-group">
        <label for="eventid">Id</label>
        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>">
        <input type="text" class="form-control" id="eventid" name="eventid" value="<?php echo $id; ?>" disabled>

      </div>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo $name; ?>" >
      </div>
      <div class="form-group">
        <label for="start">Début</label>
        <input type="text" class="form-control" id="start" name="start" data-date-format="YYYY-MM-DD HH:mm" value="<?php echo $start; ?>"/>
      </div>
      <div class="form-group">
        <label for="end">Fin</label>
        <input type="text" class="form-control" id="end" name="end" data-date-format="YYYY-MM-DD HH:mm" value="<?php echo $end; ?>"/>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" name="L"> Louveteaux
        </label>
        <label>
          <input type="checkbox" name="S"> Scouts
        </label>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>

      <hr>
    <h2> Liste des Événements </h2>
    <table class="table table-hover">
    <theader>
      <tr>
        <th>id</th>
        <th >événement</th>
        <th >début</th>
        <th >fin</th>
      </tr>
    </theader>
    <tbody>
      <?php
        $json = file_get_contents('events.json');
        $json_array = json_decode($json, true);
        echo makeEventRows($json_array["result"]);
      ?>
    </tbody>
    </table>

      <hr>
      <footer>
        <p>&copy; S<sup>t</sup> Joseph 2014 - Hosted by <a href="http://scoutnet.be">scoutnet.be</a></p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="jquery/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="lib/moment.js"></script>
    <script src="lib/date-fr.js"></script>
    <script src="lib/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript">
            $(function () {
                $('#start').datetimepicker({
                  language: 'fr'
                });
                $('#end').datetimepicker({
                  language: 'fr'
                });
            });
        </script>
  </body>
</html>
