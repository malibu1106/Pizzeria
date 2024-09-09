document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('si_password');
    const retypedPasswordInput = document.getElementById('si_retyped_password');
    const errorMessage = document.getElementById('error-message');
    const signupForm = document.getElementById('signup-form');

    // Fonction pour vérifier la robustesse du mot de passe
    function validatePassword(password) {
        const minLength = 8;
        const containsUppercase = /[A-Z]/.test(password); // Vérifie la présence de majuscules
        const containsSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password); // Vérifie la présence de caractères spéciaux
        return {
            lengthValid: password.length >= minLength,
            hasUppercase: containsUppercase,
            hasSpecialChar: containsSpecialChar
        };
    }

    // Mettre à jour les messages de validation du mot de passe
    function updatePasswordFeedback() {
        const password = passwordInput.value;
        const validation = validatePassword(password);

        let feedbackMessage = '';
        if (!validation.lengthValid) {
            feedbackMessage += 'Le mot de passe doit contenir au moins 8 caractères.<br>';
        }
        if (!validation.hasUppercase) {
            feedbackMessage += 'Le mot de passe doit contenir au moins une majuscule.<br>';
        }
        if (!validation.hasSpecialChar) {
            feedbackMessage += 'Le mot de passe doit contenir au moins un caractère spécial.<br>';
        }
        if (password !== retypedPasswordInput.value) {
            feedbackMessage += 'Les mots de passe ne correspondent pas.<br>';
        }

        errorMessage.innerHTML = feedbackMessage;
    }

    // Vérification en temps réel lors de la saisie
    passwordInput.addEventListener('input', updatePasswordFeedback);
    retypedPasswordInput.addEventListener('input', updatePasswordFeedback);

    // Gestion de la soumission du formulaire
    signupForm.addEventListener('submit', function(event) {
        const password = passwordInput.value;
        const retypedPassword = retypedPasswordInput.value;
        const validation = validatePassword(password);

        // Empêcher la soumission si le mot de passe n'est pas valide
        if (!validation.lengthValid || !validation.hasUppercase || !validation.hasSpecialChar || password !== retypedPassword) {
            event.preventDefault();
            errorMessage.textContent = 'Veuillez corriger les erreurs dans le formulaire.';
        }
    });

    // Gestion des boutons pour basculer entre les formulaires
    const showSigninBtn = document.getElementById('show-signin-btn');
    const showLoginBtn = document.getElementById('show-login-btn');
    const loginForm = document.getElementById('login-form');
    const signinForm = document.getElementById('signin-form');

    showSigninBtn.addEventListener('click', function() {
        loginForm.style.display = 'none';
        signinForm.style.display = 'block';
        showSigninBtn.style.display = 'none';
        showLoginBtn.style.display = 'inline-block';
    });

    showLoginBtn.addEventListener('click', function() {
        signinForm.style.display = 'none';
        loginForm.style.display = 'block';
        showSigninBtn.style.display = 'inline-block';
        showLoginBtn.style.display = 'none';
    });
});
