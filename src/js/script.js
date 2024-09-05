/* Language switcher */
let language = 'french'; // Valeur initiale en français
let languageSwitcher = document.getElementById('language_switcher_button');

// Fonction pour charger les traductions depuis le fichier JSON
async function loadTranslations() {
    try {
        const response = await fetch('translations.json');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const translations = await response.json();
        return translations;
    } catch (error) {
        console.error('Failed to load translations:', error);
        return {};
    }
}

// Fonction pour mettre à jour les textes en fonction de la langue sélectionnée
function updateTexts(language, translations) {
    const langKey = language === 'english' ? 'en' : 'fr';

    document.querySelectorAll('[data-translate]').forEach(el => {
        const key = el.getAttribute('data-translate');
        if (translations[langKey][key] !== undefined) {
            el.innerText = translations[langKey][key];
        }
    });


}

// Fonction pour changer la langue
async function switchLanguage() {
    if (language === 'french') {
        language = 'english';
        languageSwitcher.src = 'img/french_flag.svg';
        languageSwitcher.alt = 'French language settings button';
    } else {
        language = 'french';
        languageSwitcher.src = 'img/english_flag.svg';
        languageSwitcher.alt = 'English language settings button';
    }

    const translations = await loadTranslations();
    updateTexts(language, translations);
}

// Événement pour changer la langue lorsque le bouton est cliqué
if (languageSwitcher) {
    languageSwitcher.addEventListener('click', switchLanguage);
}

// Chargement initial des traductions en français
(async function () {
    const translations = await loadTranslations();
    updateTexts('french', translations);
})();