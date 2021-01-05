(function($) {
  const ResearchRedirect = {
    start: function() {
      this.redirect();     
    },

    redirect: function() {
      window.setTimeout(function(){
        window.location.href = document.getElementById("destination").value;
      }, 3000);  
    },    
  }
  $(function() {
    ResearchRedirect.start();
  });  
})(jQuery);