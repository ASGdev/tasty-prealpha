var all_links;
var cats_colors;
var all_collections;
var perms;

function init(){
	$.ajax({
	  dataType: "json",
	  url: 'data/colors.json',
	  success: function(data){
	  	cats_colors = data;
        populate_cats_colors();
        $.ajax({
		  dataType: "json",
		  url: 'data/permissions.json',
		  success: function(data){
		  	perms = data;
		  	console.log(perms);
	        show_links();      
		  }
		});   
	  }
	});

	$(document).on('click', '.card', function(e){
		if(perms.allow_link_deletion){
			$('.card').find('#cta').remove();
			if($(this).hasClass("c-selected")){
				$(this).find('#cta').remove();
			}
			else {
				$(this).append('<div class="action" id="cta"><i class="fa fa-trash" style="color:white" onclick="delete_link();"></i><i class="fa fa-share" style="color:white" onclick="open_share_dialog();"></i></div>');
			}
			$(this).toggleClass( "c-selected" );
		}		
	});
	
	$(document).on('click', '.title', function(e){
		var card_id = $(this).parent().parent().attr('id');
		var counter = $("#"+card_id+" .click_count_wrapper").html();
		counter++;
		$("#"+card_id+" .click_count_wrapper").empty().append(counter);
		activity_feedback('clicks', card_id, counter);
	});

	/* hack for tagit */
	jQuery.curCSS = jQuery.css;
	$('.tagit-hidden-field').css("display", "none");
}

function getClienPermissions(){
	$.ajax({
	  dataType: "json",
	  url: 'data/colors.json',
	  success: function(data){     
	  }
	});
}

function delete_link(){
	// new code
	var id = event.target.parentNode.parentNode.id.substring(5);
	// 
	//var datetime = $(event.target).parents('.card').find('.datetime').text();
	var title = $(event.target).parents('.card').find('.title').text();
	console.log("Deleting card with title: "+title+" and id: "+id);
	$.ajax({
		type:'POST',
		url: 'app/delete-link.php',
		data: {id:id, title:title},
		success: function(data) {
			console.log('suppression..');
			console.log("resultat del : "+data);
			show_links();
		}
	});
	
}
function filter_by_tag(tagname){
    $('#app-content').empty();
	
	if(typeof(tagname)==='undefined'){
		var tagname = $('#filter-by-tag-field').val();
	}
	
    $('#app-content').append('<span class="app-title-1">Filtrage par tag : </span><span class="app-title-2">'+tagname+'</span><br />');
    
    for(var i=0;i<all_links.length;i++){
	   var tags = all_links[i][2].split(',');
	   for(var j=0;j<tags.length;j++){
		 //$('#app-content').append('checking for : '+all_links[i][0] + ' and tag '+tags[j] +'<br/>');
	    if(tags[j].indexOf(tagname) != -1){
			$('#app-content').append('<div class="card"><div class="content"><span class="title"><a href="'+all_links[i][3]+'" target="_blank" >'+all_links[i][0]+'</a></span><p>'+all_links[i][1]+'<p/></div></div>');
		}
	   }
       
    }
}

function show_collection(collectionTitle){
	$('#app-content').empty();
	$('#app-content').append('<span class="app-title-1">Collection / </span><span class="app-title-2">'+collectionTitle+'</span><br />');

	$('#app-content').append('<div class="row">');
        for(var i=0;i<all_links.length;i++){

        	if(all_links[i][9] == collectionTitle)
        	{
				if(all_links[i][3]){
					var tags = all_links[i][3].split(',');
					var tags_output = "";
					for(var j=0;j<tags.length;j++){
						tags_output = tags_output+'<a href="#" onclick="filter_by_tag(\''+tags[j]+'\')">'+tags[j]+'</a>';
					}
				}
				var card = '<div class="card '+all_links[i][4]+'" id="card-'+all_links[i][7]+'">';
				switch(all_links[i][8]){
					case 'link':
								card = card + '<div class="type-icon"><i class="fa fa-link"></i></div>';
								break;
					case 'video':
								card = card + '<div class="type-icon"><i class="fa fa-video-camera"></i></div>';
								break;
					case 'pict':
								card = card + '<div class="type-icon"><i class="fa fa-camera"></i></div>';
								break;
					default:
								card = card + '<div class="type-icon"></div>';
								break;
				}
				card = card + '<div class="content"><span class="title"><a href="'+all_links[i][3]+'" target="_blank" >'+all_links[i][0]+'</a></span><p>'+all_links[i][1]+'<p/>';
				if(all_links[i][5]){
					card = card + '<br /><p class="datetime">' + all_links[i][5] + '</p>';
				}
				card = card + '<p class="counter"><span class="click_count_wrapper">'+all_links[i][6]+'</span> clicks</p>';
				if(tags_output){
						card = card + '</div><div class="action">' + tags_output + '</div>';	
				}
            	$('#app-content').append(card+'</div>');
            }
    	}
		$('#app-content').append('</div>');	

}


function show_collection_landing(){
	$('#app-content').empty();
	$('#app-content').append('<span class="app-title-1">Collections / </span><br />');

	$.ajax({
        type:'GET',
        url: 'app/get-collections.php',
        dataType: "json",
        success: function(data) {
			all_collections = data;
            $('#app-content').append('<div class="row">');
            for(var i=0;i<data.length;i++){
				var card = '<div class="card collection" id="card">';
				card = card + '<div class="content" onclick="show_collection(\''+data[i][0]+'\')"><span class="title">'+data[i][0]+'</span>';
                $('#app-content').append(card+'</div>');          
        	}
			$('#app-content').append('</div>');	
        }
    });
}

function filter_by_category(category_name){
    $('#app-content').empty()
					 .append("<span>Filter by category : </span><span>"+category_name+"<span>");

}

function show_links(){
   $.ajax({
        type:'GET',
        url: 'app/get-links.php',
        dataType: "json",
        success: function(data) {
			all_links = data;
            $('#app-content').empty()
							 .append('<div class="row">');
            for(var i=0;i<data.length;i++){
				if(data[i][3]){
					var tags = data[i][3].split(',');
					var tags_output = "";
					for(var j=0;j<tags.length;j++){
						tags_output = tags_output+'<a href="#" onclick="filter_by_tag(\''+tags[j]+'\')">'+tags[j]+'</a>';
					}
				}
				//console.log('Tag output : '+tags_output);
				var card = '<div class="card" id="card-'+data[i][7]+'">';
				switch(data[i][8]){
					case 'link':
								card = card + '<div class="type-icon"><i class="fa fa-link"></i></div>';
								break;
					case 'video':
								card = card + '<div class="type-icon"><i class="fa fa-video-camera"></i></div>';
								break;
					case 'pict':
								card = card + '<div class="type-icon"><i class="fa fa-camera"></i></div>';
								break;
					default:
								card = card + '<div class="type-icon"></div>';
								break;
				}
				card = card + '<div class="content"><span class="title"><a href="'+data[i][3]+'" target="_blank" >'+data[i][0]+'</a></span><p class="link-desc">'+data[i][2]+'<p/>';
				if(data[i][5]){
					card = card + '<p class="datetime">' + data[i][5] + '</p>';
				}
				if((!data[i][6] == "null") && (!data[i][6] == "NaN")){
					card = card + '<p class="counter"><span class="click_count_wrapper">'+data[i][6]+'</span> clicks</p>';
				}
				
				if(tags_output){
						card = card + '</div><div class="action">' + tags_output + '</div>';	
				}
				
                $('#app-content').append(card+'</div>');
                
        	}
        	toogleView("mosaicView");
			$('#app-content').append('</div>');	
        }
    });
}

function show_submission_form(){
    var url = $('#url').val();
    $.ajax({
        type:'GET',
        url: 'app/link-form.php',
        data: {url:url},
        success: function(data) {
            $('#app-content').empty().html(data);
			$('#form-url').val(url);
        }
    });
}

function process_link(){
	save_link();
}

function save_link(){
	var tags = $("#inputTags").tagit("assignedTags");
	var tags_list = tags.join();
    var titre = $('#titre').val();
    var url = $('#tadaurl').val();
    var description = $('#description').val();
  	var datetime = $('#submission-date').text();
  	var type = getType();
  	var categories = getCategories();
  	var collections = getCollections();
    $.ajax({
        type:'POST',
        url: 'assets/add-link.php',
        data: {title:titre,url:url,description:description,tags:tags_list,datetime:datetime,type:type,categories:categories,collections:collections},
        success: function(data) {
            console.log(data);
            if(data == 1){
                $('#app-content').append('<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Lien ajouté avec succès !</strong></div>');
            		setTimeout(function(){show_links()},2000);
            }
            else {
            	$('#app-content').append('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Erreur :(</strong></div>');
            
            }
        }
    });
}

function getType(){
	//link, video, pict
	var childs = document.getElementById("chooseLinkWrapper").getElementsByTagName("I");
	var index, type;
	for(index=0;index<childs.length;index++){
		console.log(childs[index].style.color);
		if (childs[index].style.color == "rgb(229, 60, 55)") { break; };
	}
	switch (index) {
		case 0: type="link";break;
		case 1: type="video";break;
		case 2: type="pict"
	}
	return type;
}

function getCategories(){
	var cats = [];
	var boxes = document.getElementById("cats-box").querySelectorAll(".box");
	for(var i=0;i<boxes.length;i++){
		cats.push(boxes[i].innerHTML);
	}
	return cats;
}

function getCollections(){
	var colls = [];
	var boxes = document.getElementById("colls-box").querySelectorAll(".box");
	for(var i=0;i<boxes.length;i++){
		colls.push(boxes[i].innerHTML);
	}
	return colls;
}



function populate_cats_colors(){
    var stylese = "";
    for(var i = 0;i<cats_colors.length;i++){
        stylese = stylese + '.'+cats_colors[i][0]+' {border-top: 2px solid '+cats_colors[i][1]+'}';
    }
    console.log(stylese);
    $('<style type="text/css">'+ stylese +'</style>').appendTo(document.head);
}

function populate_tag_cloud(){
}

function activity_feedback(type, id, count){
	id = id.substring(5);
	$.ajax({
        type:'POST',
        url: 'app/activity-feedback.php',
        data: {type:type,id:id,count:count},
        success: function(data) {
            console.log(data);
        }
    });
}

/*--------- SHARING ------------*/
function open_share_dialog(){
	$('#sharecenter').modal("show");
	generate_tw_link();
}

function generate_tw_link(){
	var a = document.getElementById('tw-link');
	a.href = "https://twitter.com/intent/tweet?text=Try";
	
}

function fb_share(){
	FB.ui({
	  	method: 'feed',
	  	link: 'https://developers.facebook.com/docs/',
	  	caption: 'An example caption',
	}, function(response){});
}


/*----------- AUTH ---------------*/
function show_loginform(){
	$('#loginform').show();
}

function disconnect(){
    location.href = "?action=logout";
}

function connect(){
	window.history.pushState( {} , 'bar', 'index.php' );
    $.ajax({
        type:'GET',
        url: 'vendor/auth.php',
        success: function(data) {
            document.getElementById("connection-body-wrapper").querySelector("#loginform").style.display = "block";
            $('#connectiondialog').modal("show");
        }
    });
}

function complete_connection(){
	var username = document.getElementById('login_input_username').value;
	var userpassword = document.getElementById('login_input_password').value;
	$.ajax({
        type:'POST',
        url: 'vendor/auth.php',
        data: {login:true,user_name:username,user_password:userpassword},
        success: function(data) {
        	console.log("Connection status : "+data);
        	location.href = "?";
        }
    });
}

/*-------------------------*/

function addCatColl(type, value){
	if((type == "category") || (event.target.id == "new-cat-add")){
		var type = "category";
		var newElement = document.getElementById("new_cat").value;
		var selectel = document.getElementById("cat-selector");
	}
	if((type == "collection") || (event.target.id == "new-coll-add")){
		var type = "collection";
		var newElement = document.getElementById("new_coll").value;
		var selectel = document.getElementById("coll-selector");
	}	
	$.ajax({
        type:'GET',
        url: 'assets/add-categories-collections.php',
        data: {data:cat},
        success: function(data) {
        	var opt = document.createElement('option');
    		opt.value = newElement;
    		opt.innerHTML = newElement;
    		selectel.appendChild(opt);
    		add_wrapper(type, newElement);
        }
    });
}

function add_wrapper(type, value){
	if(typeof(value) === 'undefined'){
		var value = event.target.options[ event.target.selectedIndex ].value;
	}
	else {
		var value = value;
	}

	var box = document.createElement('div');
	box.setAttribute("class", "box");
	box.innerHTML = value;
	box.addEventListener("click", remove_wrapper);

	if((type == "category") || (event.target.id == "cat-selector")){
		document.getElementById("cats-box").insertBefore(box, document.getElementById("cat-selectbox"));
	}
	if((type == "collection") || (event.target.id == "coll-selector")){
		document.getElementById("colls-box").insertBefore(box, document.getElementById("coll-selectbox"));
	}
}

function remove_wrapper(){
	event.target.remove();
}

/*---------- VIEW AND UI ----------*/
function toogleView(view){
	if((event.target.id == "mosaicView") || (view == "mosaicView")){
		var cards = document.querySelectorAll(".card");
		for(var i=0;i<cards.length;i++){
			cards[i].style.width = "350px";
			cards[i].querySelector(".link-desc").style.height = "50px";
		}
	}
	if((event.target.id == "listView") || (view == "listView")){
		var cards = document.querySelectorAll(".card");
		for(var i=0;i<cards.length;i++){
			cards[i].style.width = "100%";
			cards[i].querySelector(".link-desc").style.height = "";
		}
	}
}

function chooseLinkType(){
	var childs = document.getElementById("chooseLinkWrapper").getElementsByTagName("I");
	for(var i =0;i<childs.length;i++){
		childs[i].style.color = "#777777";
	}
	event.target.style.color = "#e53c37";
}

