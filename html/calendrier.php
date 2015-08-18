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
    <link rel="stylesheet" href="bootstrap-calendar/css/calendar.css">

    <!-- Custom styles for this template -->
    <link href="default.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <?php include 'nav.php'; ?>

    <div class="container">
      <h1>Évenements</h1>
      <h2 id="eventList">Liste de tous les événements</h2>

      <table class="table table-hover">
      <thead>
        <tr>
          <th>Événement</th>
          <th>Date</th>
          <th>Section</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $json = file_get_contents('events.json');
        $json_array = json_decode($json, true);
        echo makeEventRows($json_array["result"], true);
        ?>
      </tbody>
      </table>
      <h2>Calendrier interactif</h2>
      <!-- Calendar commands -->
      <div class="page-header">
        <div class="pull-right form-inline">
          <div class="btn-group">
            <button class="btn btn-primary" data-calendar-nav="prev">Précédent</button>
            <button class="btn btn-default" data-calendar-nav="today">Aujourd'hui</button>
            <button class="btn btn-primary" data-calendar-nav="next">Suivant</button>
          </div>
          <div class="btn-group">
            <button class="btn btn-warning active" data-calendar-view="month">Mois</button>
          </div>
        </div>

        <h3></h3>
      </div>
      <!-- End Calendar commands -->

      <div id="calendar"></div>
      <br>


      <hr>

      <footer>
        <p>&copy; S<sup>t</sup> Joseph 2014</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="underscore/underscore-min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootstrap-calendar/js/calendar.js"></script>
    <script type="text/javascript" src="bootstrap-calendar/js/language/fr-FR.js"></script>
    <!--<script type="text/javascript" src="bootstrap-calendar/js/app.js"></script>-->

    <script type="text/javascript">
      var calendar = $('#calendar').calendar(
        {
          tmpl_path: "tmpls/",
          language: "fr-FR",
          events_source: "events.json",
          onAfterViewLoad: function(view) {
            $('.page-header h3').text(this.getTitle());
            $('.btn-group button').removeClass('active');
            $('button[data-calendar-view="' + view + '"]').addClass('active');
          }
        });
      $('.btn-group button[data-calendar-nav]').each(function() {
        var $this = $(this);
        $this.click(function() {
          calendar.navigate($this.data('calendar-nav'));
        });
      });

      $('.btn-group button[data-calendar-view]').each(function() {
        var $this = $(this);
        $this.click(function() {
          calendar.view($this.data('calendar-view'));
        });
      });
    </script>


  </body>
</html>
