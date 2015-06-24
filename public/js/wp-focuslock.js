window.wpfocuslock = function() {
  jQuery('.focuspoint').focusPoint({
    throttleDuration: 1000
  });
}

jQuery(document).ready(function( $ ) {
  window.wpfocuslock();
});