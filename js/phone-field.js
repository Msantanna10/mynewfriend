// Brazilian phone mask
var SPMaskBehavior = function (val) {
return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    },clearIfNotMatch: true
};

// Adds mask to fields with this class
$(document).ready(function(){
$('input.telefone').mask(SPMaskBehavior, spOptions);
});