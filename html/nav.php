<?php $file = pathinfo($_SERVER["SCRIPT_FILENAME"], PATHINFO_FILENAME); ?>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Unité S<sup>t</sup> Joseph </a>
        </div>
        <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li <?php if ($file=="index") { echo "class=active"; } ?>><a href="index.php">Accueil</a></li>
          <li <?php if ($file=="presentation") { echo "class=active"; } ?>><a href="presentation.php">Présentation</a></li>
          <li <?php if ($file=="photos") { echo "class=active"; } ?>><a href="photos.php">Photos</a></li>
          <li <?php if ($file=="calendrier") { echo "class=active"; } ?>><a href="calendrier.php">Calendrier</a></li>
          <li <?php if ($file=="documents-loups" or $file=="documents-scouts") { echo "class=active"; } ?> class="dropdown">
            <a href="#" data-toggle="dropdown">
              Documents <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li <?php if ($file=="documents-loups") { echo "class=active"; } ?>><a href="documents-loups.php">Louveteaux</a></li>
              <li <?php if ($file=="documents-scouts") { echo "class=active"; } ?>><a href="documents-scouts.php">Scouts</a></li>
            </ul>
          </li>
        </ul>
          <ul class="nav navbar-right navbar-nav">
            <!--<li <?php if ($file=="sign-in") { echo "class=active"; } ?>><a href="sign-in.php">Sign in</a></li> -->
            <li <?php if ($file=="contact") { echo "class=active"; } ?>><a href="contact.php">Contact</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
