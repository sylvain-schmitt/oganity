import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const themeDropdown = document.getElementById("theme-dropdown");
    
    // Fonction pour afficher/masquer le dropdown
    window.toggleThemeDropdown = function() {
        themeDropdown.classList.toggle("hidden");
    }

    // Fonction pour changer de thème
    window.changeTheme = function (newTheme) {
        localStorage.setItem("color-theme", newTheme);
        if (newTheme === "dark") {
            document.documentElement.classList.add("dark");
        } else if (newTheme === "light") {
            document.documentElement.classList.remove("dark");
        } else {
            if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        }
    };

    // Appliquer le thème au chargement de la page
    let theme = localStorage.getItem("color-theme") || "system";
    window.changeTheme(theme);
});
