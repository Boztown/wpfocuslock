jQuery(document).ready(function( $ ) {

  var $hiddenCoordsField = $('[name$="[focuslock_coords]"]');
  var $hiddenMouseCoordsField = $('[name$="[focuslock_mouse_coords]"]');
  var $imageWrapper = $('#focuslock-image-wrapper');
  var dotSize = '22';

  if ($hiddenMouseCoordsField.val().length > 0) {
    var coords = $hiddenMouseCoordsField.val().split('|');
    createDot(coords[1], coords[0]);
  }

  $("#focuslock-image-wrapper > img").click(function (ev) {

    var imageW = $(this).width();
    var imageH = $(this).height();

    var mouseX = ev.offsetX;
    var mouseY = ev.offsetY;

    var focusX = (mouseX/imageW - .5)*2;
    var focusY = (mouseY/imageH - .5)*-2;

    var centeredMouseX = mouseX - (dotSize / 2);
    var centeredMouseY = mouseY - (dotSize / 2);

    if ($imageWrapper.find(".focuslock-dot").length == 0) {
      createDot(centeredMouseY, centeredMouseX);
    } else {
      moveDot(mouseY - (dotSize / 2),mouseX - (dotSize / 2));
    }

    $hiddenCoordsField.val(focusX + '|' + focusY);
    $hiddenMouseCoordsField.val(centeredMouseX + '|' + centeredMouseY);
  });

  function moveDot(top, left) {
    $imageWrapper.find(".focuslock-dot")
    .css('top', top + 'px')
    .css('left', left + 'px');    
  }

  function createDot(top, left) {
    $imageWrapper.append(
      $('<div></div>')
          .addClass('focuslock-dot')
          .css('top', top + 'px')
          .css('left', left + 'px')
          .css('width', dotSize + 'px')
          .css('height', dotSize + 'px'))    
  }

});