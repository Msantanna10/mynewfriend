// Scroll to listing div if query_vars exists in the URL
$(document).ready(function() {
if (window.location.href.indexOf("cidade") > -1 || window.location.href.indexOf("estado") > -1 || window.location.href.indexOf("tamanho") > -1 || window.location.href.indexOf("especie") > -1) {
    $('html, body').animate({scrollTop: $('#listagem').offset().top - 85}, 1000)
}
});