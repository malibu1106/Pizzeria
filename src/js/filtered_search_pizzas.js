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
        const ingredientsArray = $('#ingredient-select').val(); // Récupère les ingrédients sélectionnés
        const selectedFilter = $('a.active-filter').attr('data-filter') || ''; // Récupère le filtre actif ou une chaîne vide

        // Requête AJAX pour récupérer les résultats
        $.ajax({
            type: 'POST',
            url: 'pizzas/search_pizzas_ajax.php',
            data: {
                ingredients: JSON.stringify(ingredientsArray),
                selected_filter: selectedFilter // Ajoute le filtre sélectionné
            },
            success: function (response) {
                $('#pizza-results').html(response); // Insère les résultats dans le div
            },
            error: function () {
                $('#pizza-results').html('Une erreur est survenue lors de la recherche.');
            }
        });
    }

    // Ajoute un écouteur d'événements pour chaque changement de sélection
    $('#ingredient-select').on('change', fetchPizzas);

    // Ajoute un écouteur d'événements pour les filtres
    $('a.filter-link').on('click', function (e) {
        e.preventDefault();
        $('a.filter-link').removeClass('active-filter'); // Retire la classe active des autres filtres
        $(this).addClass('active-filter'); // Ajoute la classe active sur le filtre sélectionné
        fetchPizzas(); // Recharge les pizzas après avoir sélectionné un filtre
    });

    // Charge initialement toutes les pizzas au démarrage
    fetchPizzas();
});
