if ( ! window.console )
  window.console = { log: function(){ } };

  var $hiddenCoordsField;
  var $hiddenMouseCoordsField;
  var $imageWrapper;
  var focusLockedInited = false;

  jQuery(document).ready(function( $ ) {
    initFocuslock();
  });
  
  function setElements() {
    $hiddenCoordsField = jQuery('[name$="[focuslock_coords]"]');
    $hiddenMouseCoordsField = jQuery('[name$="[focuslock_mouse_coords]"]');
    $imageWrapper = jQuery('#focuslock-image-wrapper');
  }

  function initFocuslock() {

    if (!focusLockedInited) {
      setElements();

      if ($hiddenMouseCoordsField.length > 0) {
        if ($hiddenMouseCoordsField.val().length > 0) {
          var coords = $hiddenMouseCoordsField.val().split('|');
          createDot(coords[1], coords[0]);
          focusLockedInited = true;  
        }
      }
    }  
  }

  var dotSize = '22';

  jQuery(document).on('mouseover', "#focuslock-image-wrapper > img", function (ev) {
    initFocuslock();
  });

  jQuery(document).on('click', "#focuslock-image-wrapper > img", function (ev) {

    setElements();

    var imageW = jQuery(this).width();
    var imageH = jQuery(this).height();

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
      jQuery('<div></div>')
          .addClass('focuslock-dot')
          .css('top', top + 'px')
          .css('left', left + 'px')
          .css('width', dotSize + 'px')
          .css('height', dotSize + 'px'))    
  }