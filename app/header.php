<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8" />
		  <title><?php echo $app_name ?></title>
      <link href="vendor/bootstrap.custom.css" rel="stylesheet" />
      <link rel="stylesheet" type="text/css" href="vendor/jquery-ui.css">
      <link href="vendor/tagit/css/jquery.tagit.css" rel="stylesheet" type="text/css">
      <link href="themes/default.css" rel="stylesheet" />
      <link rel="stylesheet" href="vendor/font-awesome.min.css">

      <script src="vendor/jquery-1.10.1.min.js"></script>
      <script src="vendor/bootstrap.min.js"></script>
		  <script src="vendor/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
		  <script src="vendor/tagit/js/tag-it.min.js" type="text/javascript" charset="utf-8"></script>  
      <script src="app/js/app.js"></script>
      <?php if($use_tw) : ?>	  
        <script type="text/javascript" async src="//platform.twitter.com/widgets.js"></script>
      <?php endif; ?>
    </head>
        
    <body onload="init()">
      <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>    
            <a class="navbar-brand" href="#" onclick="show_links()"><?php echo $app_name ?></a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

        	  <?php
        		if(isset($_SESSION['user_name']) && ($_SESSION['user_is_logged_in']==true)){
        		 echo '
        		  <div class="navbar-form navbar-left">
          			<div class="form-group">
          			 <input type="text" class="form-control theme-input" placeholder="Ajouter un lien" id="url">
        			   <button onclick="show_submission_form()" class="btn btn-default">Ajouter</button>
                </div>
        		  </div>';
        		}
        		?>
            <?php if($allow_search_by_tag) : ?>
              <div class="navbar-form navbar-left" role="search">
                <div class="form-group">
                  <input type="text" class="form-control theme-input" id="filter-by-tag-field" placeholder="Rechercher par tag">
                  <button onclick="filter_by_tag()" class="btn btn-default">Rechercher</button>
                </div>
            	</div>
            <?php endif; ?>
            <div class="navbar-form navbar-left">
              <div class="form-group">
                <?php if($allow_collection_browsing) : ?>
                  <button onclick="show_collection_landing()" class="btn btn-default">Collections</button>
                <?php endif; ?>
                <i class="fa fa-th-large" id="mosaicView" style="font-size:25px;cursor:pointer" onclick="toogleView()"></i>
                <i class="fa fa-th-list" id="listView" style="font-size:25px;cursor:pointer" onclick="toogleView()"></i>
              </div>
            </div>
            <ul class="nav navbar-nav navbar-right">
            <?php if($show_about) : ?>
      		    <li><a href="#" onclick="$('#about-dialog').modal('show');">A propos / Aide</a></li>
            <?php endif; ?>  
        	  <?php
            if(isset($_SESSION['user_name']) && ($_SESSION['user_is_logged_in']==true)){
                	echo '<li onclick="disconnect()"><a href="#">Se déconnecter</a></li>';
        		}else {
        			echo '<li onclick="connect()"><a href="#">Se connecter</a></li>';
        		}
        	  ?>
            </ul>
          </div>
        </div>
      </nav>
		
<div class="modal" id="about-dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">A propos / aide</h4>
          </div>
          <div class="modal-body">
			  <p class="lead">Tasty : gestionnaire de signets et agrégateur de contenu.</p>
			  <p>Version béta 0.1</p>
			  <br />
			  <p>Projet développé par <a href="http://asgdev.fr">ASGdev</a>.</p>
			  <br />
			  <ul>
			  	<li><a href="#">Aide à l'utilisation</a></li>
				<li><a href="#">Mentions légales / termes et conditions de service</a></li>
				<li><a href="#">Reporter un bug</a></li>
				  <li><a href="#">Suggérer une idée</a></li>
			  </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
</div>

<div class="modal" id="sharecenter">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Partager</h4>
          </div>
          <div class="modal-body">
          <p class="lead">Par les réseaux sociaux</p>
          <a id="tw-link"><i class="fa fa-twitter"></i></a>
          <i class="fa fa-facebook-official" onclick="fb_share();"></i>
          <hr />
          <p class="lead">Par mail</p>
          <i class="fa fa-envelope"></i>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
</div>

<div class="modal" id="connectiondialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Connection</h4>
          </div>
          <div class="modal-body" id="connection-body-wrapper">
            <div id="loginform" style="display:none">
              <h2>Login</h2>
              <label for="login_input_username">Utilisateur (ou email)</label>
              <input id="login_input_username" type="text" name="user_name" required />
              <br />
              <label for="login_input_password">Mot de passe</label>
              <input id="login_input_password" type="password" name="user_password" required />
              <br />
              <button name="login" onclick="complete_connection()">Se connecter</button>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
</div>
        
<div id="app-content" class="container">

