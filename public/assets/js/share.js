$(document).on('click', '.share--btn', function(e){
    $('#shareModal').modal('show');
});    


$(document).on("click", "#copy-referral_link", function() {
    copyToClipboard();
});

function copyToClipboard() {
    /* Get the text field */
  var copyText = document.getElementById("referral--link");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

  navigator.clipboard.writeText(copyText.value);
}