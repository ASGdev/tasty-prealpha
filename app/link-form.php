<?php
include_once('../vendor/auth.php');

if(isset($_SESSION['user_name']) && ($_SESSION['user_is_logged_in']==true)) : ?>
  <?php
    if(isset($_GET['url'])){
      $url = $_GET['url'];
    }
    else {
      $url = "";
    }

    $collections_str = file_get_contents('../data/collections.json');
    $collections = json_decode($collections_str);
    $cats_str = file_get_contents('../data/categories.json');
    $cats = json_decode($cats_str);
  ?>

<div class="form-horizontal">
  <fieldset>
    <legend>Ajouter un lien</legend>
    <div class="form-group">
      <label for="titre" class="col-lg-2 control-label">Titre du lien : </label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="titre" name="title" placeholder="" required>
      </div>
    </div>
    <div class="form-group">
      <label for="url" class="col-lg-2 control-label">URL du lien : </label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="url" id="tadaurl" placeholder="" required value="<?php echo $url ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Description : </label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" id="description" name="description"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Type : </label>
      <div class="col-lg-10" id="chooseLinkWrapper" onclick="chooseLinkType()">
        <div style="width:25px;height:25px;text-align:center;float:left;margin:10px 10px;font-size:25px;cursor:pointer">
          <i class="fa fa-link"></i>
        </div>
        <div style="width:25px;height:25px;text-align:center;float:left;margin:10px 10px;font-size:25px;cursor:pointer">
          <i class="fa fa-video-camera"></i>
        </div>
        <div style="width:25px;height:25px;text-align:center;float:left;margin:10px 10px;font-size:25px;cursor:pointer">
          <i class="fa fa-camera"></i>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Categorie : </label>
      <div class="col-lg-5" id="cats-box">
      <div class="selectbox" id="cat-selectbox">
        <select id="cat-selector" onchange="add_wrapper()">
          <?php
            foreach ($cats as $value) {
              echo "<option>".$value."</option>";
            }
          ?>
        </select>
      </div>
      </div>
      <div class="col-lg-5">
        Nouvelle catégorie :
        <div class="input-group">
          <input type="text" class="form-control" name="" id="new_cat" placeholder="">
          <span class="input-group-btn">
            <button class="btn btn-default" id="new-cat-add" onclick="addCatColl()">Ajouter</button>
          </span>        
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Collection : </label>
      <div class="col-lg-5" id="colls-box">
        <div class="selectbox" id="coll-selectbox">
          <select id="coll-selector" onchange="add_wrapper()">
          <?php
            foreach ($collections as $value) {
              echo "<option>".$value."</option>";
            }
          ?>
          </select>
        </div>
      </div>
      <div class="col-lg-5">
        Nouvelle collection : 
        <div class="input-group">
          <input type="text" class="form-control" name="" id="new_coll" placeholder="">
          <span class="input-group-btn">
            <button class="btn btn-default" id="new-coll-add" onclick="addCatColl()">Ajouter</button>
          </span>        
        </div>
      </div>
    </div>
	  <div class="form-group">
      <label for="inputTags" class="col-lg-2 control-label">Tags : </label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="tagslist" id="inputTags" placeholder="Tag">
      </div>
    </div>
	<p>Date : <span id="submission-date"><?php echo(date("Y-m-d h:i:s")) ?></span></p>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button class="btn btn-default" onclick="show_links()">Annuler</button>
        <button class="btn btn-primary" onclick="process_link()">Ajouter</button>
      </div>
    </div>
  </fieldset>
	<script type="text/javascript">
    $(document).ready(function() {
        $("#inputTags").tagit();
    });
  </script>
</div>

  <?php else: ?>
    <p>Accès interdit</p>;
  <?php endif; ?>