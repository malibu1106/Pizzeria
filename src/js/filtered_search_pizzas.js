$(document).ready(function () {
    // Initialiser Select2 avec les images
    $('#ingredient-select').select2({
        templateResult: formatState,
        templateSelection: formatState
    });

    function formatState(state) {
        if (!state.id) {
            return state.text; // Affichage par défaut (text) si aucune image
        }
        var baseUrl = $(state.element).data('image');
        var $state = $(
            '<span><img src="' + baseUrl + '" class="img-flag" style="width: 20px; height: 20px; margin-right: 10px;"/>' + state.text + '</span>'
        );
        return $state;
    }

    // Fonction pour récupérer les résultats de la recherche
    function fetchPizzas() {
        const ingredientsArray = $('#ingredient-select').val();

        // Requête AJAX pour récupérer les résultats
        $.ajax({
            type: 'POST',
            url: 'search_pizzas_ajax.php',
            data: { ingredients: JSON.stringify(ingredientsArray) },
            success: function (response) {
                $('#pizza-results').html(response);
            },
            error: function () {
                $('#pizza-results').html('Une erreur est survenue lors de la recherche.');
            }
        });
    }

    // Ajoute un écouteur d'événements pour chaque changement de sélection
    $('#ingredient-select').on('change', fetchPizzas);

    // Charge initialement toutes les pizzas au démarrage
    fetchPizzas();
});