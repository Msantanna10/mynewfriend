// Check if cookie exists (Pop up to help the initiative)
if (document.cookie.indexOf('popup') >= 0) { /* If cookie exists, doesnt show the pop up */ }
else {
  // Se não existe, exibe PopUp
  setTimeout(
  function() {
    $('#ModalAjuda').css('display','grid');
  }, 10000);          
}
// Sets Cookie when user closes the modal
$('#ModalAjuda .close, #ModalAjuda #action').click(function() {
  var date = new Date();
  // Minutes: the first number from the three below, the first one is the quantity of minutes
  date.setTime(date.getTime() + (60 * 60 * 1000));
  // Using the variable 'date' in 'expires' transforms into minutes. Otherwise, numbers in Expire will be considered as days
  Cookies.set('popup', 'popup_value', { expires: 1, path: '/' });
  $('#ModalAjuda').fadeOut(300);
});