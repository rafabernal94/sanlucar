$(document).ready(function() {
    "use strict";
    i18next.init({
        lng: 'es',
        resources: {
            es: {
                translation: {
                    "veryWeak": "Muy Débil",
                    "weak": "Débil",
                    "normal": "Normal",
                    "medium": "Media",
                    "strong": "Fuerte",
                    "veryStrong": "Muy Fuerte",
                }
            }
        }
    }, function () {
        var options = {};
        options.ui = {
            container: "#pwd-container",
            showVerdictsInsideProgressBar: true,
            viewports: {
                progress: ".pwstrength_viewport_progress"
            },
            progressBarExtraCssClasses: "progress-bar-striped active"
        };
        $('#password').pwstrength(options);
    });
});
