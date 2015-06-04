jQuery(document).ready(function( $ ) {

  var $hiddenCoordsField = $('[name$="[focuslock_coords]"]');
  var $hiddenMouseCoordsField = $('[name$="[focuslock_mouse_coords]"]');

  $("#focuslock-image-wrapper > img").click(function (ev) {

    var imageW = $(this).width();
    var imageH = $(this).height();

    var mouseX = ev.offsetX;
    var mouseY = ev.offsetY;

    var focusX = (mouseX/imageW - .5)*2;
    var focusY = (mouseY/imageH - .5)*-2;

    var size = '22';

    var centeredMouseX = mouseX - (size / 2);
    var centeredMouseY = mouseY - (size / 2);

    if ($("#focuslock-image-wrapper > .focuslock-dot").length == 0) {
      $("#focuslock-image-wrapper").append(
        $('<div></div>')
            .addClass('focuslock-dot')
            .css('top', centeredMouseX + 'px')
            .css('left', centeredMouseX + 'px')
            .css('width', size + 'px')
            .css('height', size + 'px')
      );
    } else {
      $("#focuslock-image-wrapper > .focuslock-dot")
            .css('top', mouseY - (size / 2) + 'px')
            .css('left', mouseX - (size / 2) + 'px');
    }

    $hiddenCoordsField.val(focusX + '|' + focusY);
    $hiddenMouseCoordsField.val(centeredMouseX + '|' + centeredMouseY);
  });

});