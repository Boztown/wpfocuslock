jQuery(document).ready(function( $ ) {

  var $hiddenCoordsField = $('[name$="[focuslock_coords]"]');

  $("#focuslock-image-wrapper > img").click(function (ev) {

    var imageW = $(this).width();
    var imageH = $(this).height();

    var mouseX = ev.offsetX;
    var mouseY = ev.offsetY;

    var focusX = (mouseX/imageW - .5)*2;
    var focusY = (mouseY/imageH - .5)*-2;

    var size = '22';

    if ($("#focuslock-image-wrapper > .focuslock-dot").length == 0) {
      $("#focuslock-image-wrapper").append(
        $('<div></div>')
            .addClass('focuslock-dot')
            .css('top', mouseY - (size / 2) + 'px')
            .css('left', mouseX - (size / 2) + 'px')
            .css('width', size + 'px')
            .css('height', size + 'px')
      );
    } else {
      $("#focuslock-image-wrapper > .focuslock-dot")
            .css('top', mouseY - (size / 2) + 'px')
            .css('left', mouseX - (size / 2) + 'px');
    }

    $hiddenCoordsField.val(focusX + '|' + focusY);
  });

});