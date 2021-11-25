$(document).on('click', '.share--btn', function(e){
    $('#shareModal').modal('show');
});    


$(document).on("click", "#copy-referral_link", function() {
    copyToClipboard();
});

$(document).on("click", "#referral--link", function() {
    copyToClipboard();
});

function copyToClipboard() {
  var copyText = document.getElementById("referral--link");

  copyText.select();
  copyText.setSelectionRange(0, 99999);

  navigator.clipboard.writeText(copyText.value);
}