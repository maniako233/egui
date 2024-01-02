// Vérifie si le cookie a été accepté et masque le pop-up en conséquence
if (document.cookie.indexOf("mon_cookie_accepte") !== -1) {
    document.getElementById('cookie-popup').style.display = 'none';
}

function acceptCookies() {
    // Fermez le pop-up côté client avec JavaScript
    document.getElementById('cookie-popup').style.display = 'none';

    // Effectuez une requête vers le serveur pour définir le cookie côté serveur avec PHP
    // Vous pouvez utiliser AJAX pour cela
    // Exemple avec Fetch API :
    fetch('cookie.php', { method: 'GET' })
        .then(response => response.text())
        .then(data => {
            // Vous pouvez omettre cette ligne si vous ne voulez pas afficher la réponse dans la console
            console.log(data);
            // Ajoutez un nouveau cookie pour indiquer que les cookies ont été acceptés
            document.cookie = "mon_cookie_accepte=true";
        })
        .catch(error => console.error(error));
}

function refuseCookies() {
    // Fermez le pop-up côté client avec JavaScript
    document.getElementById('cookie-popup').style.display = 'none';

    // Vous pouvez ajouter du code supplémentaire ici si nécessaire pour gérer le refus des cookies
}