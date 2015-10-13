// Events
$(document).on('click', '.categori', goTo);
$(document).on('click', '.back', returnTo);
$(document).on('click', '#signIn', signInPage);
$(document).on('click', '.answer input', answer);
$(document).on('click', 'h1', accueil);
$(document).on('click', '#signInOk', signInAction);
$(document).on('click', '#logIn', logIn);
$(document).on('click', '#logOut', logOut);
$(document).on('click', '#newTopic', newTopic);
$(document).on('click', '#sendNewTopic', sendNewTopic);

// Navigation

function newTopic(event) {
	var $cateId = $('#newTopic').data('cateid');
	var $catename = $('#newTopic').data('catename');
	window.history.pushState('object or string', 'Title', 'index.php?page=newTopicPage&cateName=' + $catename + '&cateId=' + $cateId);
	$.ajax({
		url: 'index.php?page=newTopicPage&cateName=' + $catename + '&cateId=' + $cateId + '&ajax=true',
		success: function(retour) {
			$('main').html(retour);
			$('h2').html('Nouveau Topic dans ' + $catename);
			console.log('ok');
		},
		type:'GET'
	});
}

function accueil(event) {
	window.history.pushState('object or string', 'Title', 'index.php');
	$.ajax({
		url: 'index.php?page=accueil&ajax=true',
		success: function(retour) {
			$('main').html(retour);
			$('h2').html('Accueil');
			console.log('ok');
		},
		type:'GET',
	});
}

function goTo(event) {
	var $target = $(event.target);
	while(!$target.hasClass('categori')){
		$target = $target.parent();
	}
	var $targetTitle = $target.children('h3').text();
	var $targetUrl = $target.data('target');
	var $targetId = $target.attr('id');

	nav($targetTitle, $targetUrl, $targetId);
}

function returnTo(event) {
	var $target = $(event.target);
	while(!$target.hasClass('back')){
		$target = $target.parent();
	}
	var $targetTitle = $target.text();
	var $targetUrl = $target.data('target');
	var $targetId = $target.data('id');

	nav($targetTitle, $targetUrl, $targetId);
}

function nav($targetTitle, $targetUrl, $targetId) {
	window.history.pushState('object or string', 'Title', 'index.php?page=' + $targetUrl + '&targetId=' + $targetId + '&cateName=' + $targetTitle );
	$.ajax({
		url: 'index.php?page=' + $targetUrl + '&targetId=' + $targetId + '&cateName=' + $targetTitle + '&ajax=true',
		success: function(retour) {
			$('main').html(retour);
			$('h2').html($targetTitle);
			console.log('ok');
		},
		type:'GET',
	});
}

function signInPage() {
	window.history.pushState('object or string', 'Title', 'index.php?page=signInPage');
	$.ajax({
		url: 'index.php?page=signInPage&ajax=true',
		success: function(retour) {
			$('main').html(retour);
			$('h2').html('Inscription');
			console.log('ok');
		},
		type:'GET',
	});
}

// Poste de réponse

function answer(event) {
	if ($('.answer textarea').val().length > 6000) {
		$('.answer span').html('Maximum 6000 caractere autorisé');
		return false;
	}
	$.ajax({
		url: 'index.php?page=answer',
		success: function(retour) {
			$('.answer textarea').val('');
			$('.answer span').html(retour);
			console.log('ok');
			window.location.reload()
		},
		type:'POST',
		data:{msg: $('.answer textarea').val(),
			topic: $('.msg input').data('topic'),
			location: document.location.href
		}
	});
}

// Inscription

function signInAction() {
	console.log($('.signIn input').attr('type'));
	$('.signIn input').each(function() {
		if ($(this).attr('type') !== 'button'
			&& $(this).attr('type') !== 'email'
			&& $(this).attr('type') !== 'button'
			&& $(this).val() === '') {
			$('.signInRetour').html('veulliez remplir tous les champs');
			return false;
		}
		$('.signInRetour').html('Ok');
	})
	if ($('#signPassword').val() !== $('#signPassword2').val()) {
		$('.signInRetour').html('Mot de passe different de la confirmation');
	};
	$.ajax({
		url: 'index.php?page=signIn',
		success: function(retour) {
			$('.signIn input').each(function() {
				if ($(this).attr('type') !== 'button') {
					$(this).val('')
				}
			})
			console.log('ok');
			$('.signInRetour').html(retour);
		},
		type:'POST',
		data:{
			identifiant: $('#signId').val(),
			pseudo: $('#signPseudo').val(),
			password: $('#signPassword').val(),
			password2: $('#signPassword2').val(),
			mail: $('#signEmail').val(),
			location: document.location.href
		}
	});
}

// Connection

function logIn() {
	$.ajax({
		url: 'index.php?page=logIn',
		success: function(retour) {
			$('.logDiv input').each(function() {
				if ($(this).attr('type') !== 'button') {
					$(this).val('');
				}
			})
			window.location.reload()
			console.log('ok');
			$('#logInMsg').html(retour);
		},
		error: function(xhr) {
			$('.logDiv input').each(function() {
				if ($(this).attr('type') !== 'button') {
					$(this).val('');
				}
			});
			$('#logInMsg').html(xhr.responseText);
		},
		type:'POST',
		data:{
			identifiant: $('#identifiant').val(),
			password: $('#password').val(),
			location: document.location.href
		}
	});
}

// deconnection

function logOut() {
	$.ajax({
		url: 'index.php?page=logOut',
		success: function(retour) {
			window.location.reload()
			console.log('ok');
			$('#logInMsg').html(retour);
		},
		type:'GET'
	});
}

// Nouveaux Topic 

function sendNewTopic() {
	$.ajax({
		url: 'index.php?page=newTopic',
		success: function(retour) {
			console.log('ok');
			$('.newTopic input').val('');
			$('.newTopic textarea').val('');
			// Redirection sur le topic créer
			window.history.pushState('object or string', 'Title', 'index.php?page=inTopic&targetId=' + retour);
			window.location.reload();
		},
		type:'POST',
		data:{
			cateId: $('#sendNewTopic').data('id'),
			titre: $('.newTopic input').val(),
			msg: $('.newTopic textarea').val(),
			location: document.location.href
		}
	});
}

// Document ready

$(function() {
	// Force le refresh au back/next
	if (window.history && window.history.pushState) {
    	$(window).on('popstate', function() {
    		window.location.reload()
    	});
	}
})