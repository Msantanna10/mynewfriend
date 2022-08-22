// Capitalize first letter while typing in side of input field
jQuery(document).ready(function($) {
    $('.first-letter-capital').keyup(function(event) {
        var textBox = event.target;
        var start = textBox.selectionStart;
        var end = textBox.selectionEnd;
        textBox.value = textBox.value.charAt(0).toUpperCase() + textBox.value.slice(1);
        textBox.setSelectionRange(start, end);
    });
});

// Lowercase first letter
jQuery(document).ready(function($) {
    $('.first-letter-lowercase').keyup(function(event) {
        var textBox = event.target;
        var start = textBox.selectionStart;
        var end = textBox.selectionEnd;
        textBox.value = textBox.value.charAt(0).toLowerCase() + textBox.value.slice(1);
        textBox.setSelectionRange(start, end);
    });
});

// Avoid space inside field
$("input.nospace").on({
keydown: function(e) {
    if (e.which === 32)
    return false;
},
change: function() {
    this.value = this.value.replace(/\s/g, "");
}
});