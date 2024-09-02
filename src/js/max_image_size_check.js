document.getElementById('uploadForm').addEventListener('submit', function (event) {
    const fileInput = document.getElementById('image_url');
    const file = fileInput.files[0];
    const maxSize = 2 * 1024 * 1024; // 2 Mo en octets

    if (file && file.size > maxSize) {
        event.preventDefault(); // Empêche l'envoi du formulaire
        alert("Le fichier est trop grand. La taille maximale est de 2 Mo.");
    }
});