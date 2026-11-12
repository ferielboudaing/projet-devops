// Petites interactions NOVA
document.addEventListener('DOMContentLoaded', function () {
    var links = document.querySelectorAll('.sidebar a');
    for (var i = 0; i < links.length; i++) {
        if (links[i].href === window.location.href) {
            links[i].className += ' active';
        }
    }
});
