(function() {
    $(document).ready(function() {
        // $('.tooltip').tooltipster({
        //     trigger: 'hover',
        //     animation: 'fade',
        //     delay: 50,
        //     theme: 'tooltipster-borderless',
        //     position: 'bottom'
        // });

         
    });

    $(window).click(function(e) {
        e.stopPropagation();
        $('.toggle-cont').filter(":visible").filter('div[role="menu"]').fadeOut("easing");
    });
    $(document).on('click', '.close-modal', function(e) {
        var menu = $(this).data('toggle');
        var menuTarget = $(menu);
        menuTarget.fadeOut("easing");
    });

    $(document).on('click', '.toggle-menu', function(e) {
        // $('.toggle-cont').filter(":visible").fadeOut("easing");
        e.stopPropagation();
        var menu = $(this).data('toggle');
        var menuTarget = $(menu);
        var ifModal = $(this).data('modal');

        if(menuTarget.is('visible')){
            menuTarget.fadeOut("easing");
        }else{
            menuTarget.fadeToggle("easing");
        }

        menuTarget.addClass('toggle-cont');      

        if (typeof ifModal != 'undefined') {
            if (ifModal == true) {
                $('body').toggleClass('overflow-hidden');
            }
        }
    });
})();

setInterval(function() {
    $("#apt_card").load(location.href + " #apt_card");
    $("#inq_card").load(location.href + " #inq_card");
    $("#pt_card").load(location.href + " #pt_card");
    $("#nav_notif").load(location.href + " #nav_notif");
    $("#mobile_notif").load(location.href + " #mobile_notif");
    $("#todays_inquiries").load(location.href + " #todays_inquiries");
    $("#mobile_notif").load(location.href + " #mobile_notif");
    $("#apt_notif").load(location.href + " #apt_notif_cont");
    $("#inq_notif").load(location.href + " #inq_notif_cont");
}, 5000);

$(document).on('click', '.archive', function(){
    var id    = $(this).data('id');
    var url   = $(this).data('url');
    var title = $(this).data('type');

    Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: 'this record will be archived',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        customClass: {
            confirmButton: 'bg-indigo-700',
            container: 'bg-white backdrop-filter backdrop-blur-md bg-opacity-20'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(url, {id:id}).done(function(){
                var table = $("#datatable").DataTable();
                table.ajax.reload();

                Swal.fire({
                    icon: 'success',
                    text: `${title} successfully archived`,
                    showCancelButton: false,
                    confirmButtonText: 'ok',
                    customClass: {
                        confirmButton: 'bg-indigo-700',
                        container: 'bg-white backdrop-filter backdrop-blur-md bg-opacity-20'
                    },
                });
            });
        }
    });        
});

$(document).ready(function(){
    $('.slider').slick({
        centerMode: true,
        centerPadding: '20px',
        slidesToShow: 4,
        arrows:false,
        autoplay:true,
        responsive: [
          {
            breakpoint: 769,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '10px',
              slidesToShow: 1
            }
          }
        ]
    });

    $('.testimonial-slider').slick({
        centerPadding: '20px',
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows:false,
        autoplay:true,
        speed: 300,
        responsive: [
          {
            breakpoint: 769,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 1,
              slidesToScroll: 1,
            }
          },
          {
            breakpoint: 480,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '10px',
              slidesToShow: 1,
              slidesToScroll: 1,
            }
          }
        ]
    });
});

$('.summernote').summernote();

history.go = function(){};
    