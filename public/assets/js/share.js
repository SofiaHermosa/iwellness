var a2a_config = a2a_config || {};
a2a_config.templates = a2a_config.templates || {};
var share_templates = ['telegram', 'messenger', 'whatsapp', 'copy_link'];

a2a_config.templates.google_gmail = {
subject: "IWellness - Experience the Difference",
body: `${window.referral_link}`,
}

a2a_config.templates.facebook = {
    redirect_uri: "https://myiwellness.com",
};

a2a_config.templates.sms = {
subject: "IWellness - Experience the Difference",
body: `${window.referral_link}`,
};

a2a_config.templates.twitter = {
    text: `IWellness - Experience the Difference: ${window.referral_link}`,
    related: "IWellness",
    hashtags: "IWellness,ExperiencetheDifference"
};

a2a_config.templates.telegram = {
    text: `IWellness - Experience the Difference: ${window.referral_link}`,
};

a2a_config.templates.facebook_messenger = {
    text: `IWellness - Experience the Difference: ${window.referral_link}`,
    redirect_uri: "https://myiwellness.com",
};

a2a_config.templates.whatsapp = {
    text: `IWellness - Experience the Difference: ${window.referral_link}`,
};

a2a_config.templates.copy_link = {
    share: `${window.referral_link}`,
};

a2a_config.templates.viber = {
    text: `IWellness - Experience the Difference: ${window.referral_link}`,
};

a2a_config.templates.line = {
    text: `IWellness - Experience the Difference: ${window.referral_link}`,
};

a2a_config.templates.wechat = {
    text: `IWellness - Experience the Difference: ${window.referral_link}`,
};

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