document.addEventListener("DOMContentLoaded", function(){
    /////// Prevent closing from click inside dropdown
    document.querySelectorAll('.dropdown-menu').forEach(function(element){
    	element.addEventListener('click', function (e) {
    		e.stopPropagation();
    	});
    })
}); 
// DOMContentLoaded  end

(function() {
  "use strict";
    /**
     * Animation on scroll
     */
    function aos_init() {
      AOS.init({
        duration: 1000,
        easing: "ease-in-out",
        once: true,
        mirror: false
      });
    }
    window.addEventListener('load', () => {
      aos_init();
    });
})();


(function () {
  
    'use strict';

  var goToTop = function() {
    $('.js-gotop').on('click', function(event){
      event.preventDefault();
      $('html, body').animate({
        scrollTop: $('html').offset().top
      }, 100, 'swing');
      return false;
    });

    $(window).scroll(function(){
      var $win = $(window);
      if ($win.scrollTop() > 200) { $('.js-top').addClass('active'); } 
      else { $('.js-top').removeClass('active'); }
    });
  };

  $(function(){
    goToTop(); 
  });

}());


// Gets cookie from cookies
function getCookie(name){
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        let c = cookies[i].trim().split('=');
        if (c[0] === name) {
            return c[1];
        }
    }
    return "";
}