// tool-tips [data-toggle="tooltip" title="Edit"]
function tool_tip() {
    $('[data-toggle="tooltip"]').tooltip({ delay: { show: 200, hide: 100 }, placement: 'auto' });
}


// Sweet alert success functions 
function success_operation(msg) {
    // Success alert auto close
    const Toast = Swal.mixin({
        toast: true, 
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
        icon: 'success',
        title: msg,
    });
}
// Sweet alert error functions
function error_operation(msg) {
    // Error alert auto close
    const Toast = Swal.mixin({
        toast: true, 
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
        icon: 'error',
        title: msg,
    });
}


// Lazy loading of images
document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages = document.querySelectorAll("img.lazy");    
  var lazyloadThrottleTimeout;
  
  function lazyload () {
    if(lazyloadThrottleTimeout) {
      clearTimeout(lazyloadThrottleTimeout);
    }    
    
    lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) { 
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
    }, 20);
  }
  
  document.addEventListener("scroll", lazyload);
  window.addEventListener("resize", lazyload);
  window.addEventListener("orientationChange", lazyload);
});


// script to toggle menu bar animations
 var animation = 'rubberBand';
 $('.icon').on('click', function () {
        $(this).toggleClass('icon--active');
     });
     $('.icon').on('click', function () {
         $(this).addClass('animated ' + animation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
         $(this).removeClass('animated ' + animation);
     });
 });

