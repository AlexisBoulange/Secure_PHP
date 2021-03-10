// On récupère toutes les figures dans un tableau
const figures = document.querySelectorAll('.gallery-items figure');
let lightbox = document.querySelector('.lightbox');

// Pour chacune des figures dans l'array figures
for (let figure of figures) {
	// On lui attribue un event au click
	figure.addEventListener('click', function (e) {
		console.log(this.dataset.gallery);
		// on supprime le comportement par défaut pour éviter les rechargements de page
		e.preventDefault();
		// on execute la fonction qui aura pour but d'ouvrir la lightbox avec le bon contenu
		// cette dernière récupère l'élément cliqué en paramètre (celui sur lequel on a mis l'écouteur d'évènement)
		lightboxOn(this);
	});
}
// Pour activer la fermeture de la lightbox
document.querySelector('#lightClose').addEventListener('click', function () {
	lightbox.style.opacity = 0;
	lightbox.style.zIndex = -1;
	document.querySelector('#lightImage').innerHTML = '';
});

function lightboxOn(elem) {
	// On récupère l'élément figure précédent, le courant sur lequel on a cliqué et le suivant
	let currentElem = elem,
		lightImage = document.querySelector('#lightImage'),
		currentSrc = currentElem.children[0].src;

	// Au clique sur #left
	document.querySelector('#lightLeft').addEventListener('click', function () {
		// On récupère le figure précédent de celui du current
		prevElem = currentElem.previousElementSibling;
		// Si le voisin précédent est null
		if (prevElem === null) {
			prevElem = currentElem.parentElement.lastElementChild;
		}

		while (prevElem.style.display === 'none') {
			currentElem = prevElem;
			prevElem = currentElem.previousElementSibling;
			if (prevElem === null) {
				prevElem = currentElem.parentElement.lastElementChild;
			}
		}
		currentElem = prevElem;

		// On récupère l'adresse de l'image à afficher
		let src = currentElem.children[0].src;

		// On modifie le contenu de lightImage par le contenu du voisin précédent
		lightImage.innerHTML = `<img src="${src}" />`;
	});

	// Au clique sur #right
	document.querySelector('#lightRight').addEventListener('click', function () {
		// On récupère le figure suivant de celui du current
		nextElem = currentElem.nextElementSibling;
		// Si le voisin suivant est null
		if (nextElem === null) {
			nextElem = currentElem.parentElement.firstElementChild;
		}

		while (nextElem.style.display === 'none') {
			currentElem = nextElem;
			nextElem = currentElem.nextElementSibling;
			if (nextElem === null) {
				nextElem = currentElem.parentElement.firstElementChild;
			}
		}
		currentElem = nextElem;
		// On récupère l'adresse de l'image à afficher
		let src = nextElem.children[0].src;
		// On modifie le contenu de lightImage par le contenu du voisin suivant
		lightImage.innerHTML = `<img src="${src}" />`;
		// on changera comme "actif" non plus l'image cliqué mais le figure suivant
		currentElem = nextElem;
	});

	// On change les pptés CSS pour faire apparaitre la lightbox
	lightbox.style.zIndex = 100;
	lightbox.style.opacity = 1;

	// On inclus notre image dans la lightbox
	document.querySelector(
		'#lightImage'
	).innerHTML = `<img src="${currentSrc}" />`;
}

/*** TRI DE LA GALLERY ***/
document.querySelector('#tri-image').addEventListener('click', function (e) {
	e.preventDefault();
	for (let figure of figures) {
		if (figure.dataset.gallery !== 'image') {
			figure.style.display = 'none';
		} else {
			figure.style.display = 'block';
		}
	}
});

document.querySelector('#tri-audio').addEventListener('click', function (e) {
	e.preventDefault();
	for (let figure of figures) {
		if (figure.dataset.gallery !== 'audio') {
			figure.style.display = 'none';
		} else {
			figure.style.display = 'block';
		}
	}
});

document.querySelector('#tri-video').addEventListener('click', function (e) {
	e.preventDefault();
	for (let figure of figures) {
		if (figure.dataset.gallery !== 'video') {
			figure.style.display = 'none';
		} else {
			figure.style.display = 'block';
		}
	}
});

document.querySelector('#tri-all').addEventListener('click', function (e) {
	e.preventDefault();
	for (let figure of figures) {
		figure.style.display = 'block';
	}
});
