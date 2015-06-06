window.focuslock = {};

if ( ! window.console )
  window.console = { log: function(){ } };

;(function($){

  "use strict"

  function focuslock() {
    
    var t = this;

    $.extend( t, {

      _construct: function() {

        $(document).on( 'click', ".edit-focuslock", function() {
          t.attachment_id = $(this).data('attachmentId');
          t.image_wrapper = $(this).parent().find('.focuslock-image-wrapper');
          t.setEdit(true);
          t.get_focus_points();
        });

        $(document).on( 'click', ".save-focuslock", function() {
          t.save();
        });

        $(document).on( 'click', ".cancel-focuslock", function() {
          t.setEdit(false);
        });

        $(document).on( 'click', ".focuslock-image-wrapper > img", function(e) {

          if (t.image_wrapper.hasClass('locked')) {
            return;
          }
          
          var imageW = $(this).width();
          var imageH = $(this).height();

          var mouseX = e.offsetX;
          var mouseY = e.offsetY;

          var focusX = (mouseX/imageW - .5)*2;
          var focusY = (mouseY/imageH - .5)*-2;

          var centeredMouseX = mouseX - (t.dotSize / 2);
          var centeredMouseY = mouseY - (t.dotSize / 2);

          if (t.image_wrapper.find(".focuslock-dot").length == 0) {
            t.createDot(centeredMouseY, centeredMouseX);
          } else {
            t.moveDot(mouseY - (t.dotSize / 2),mouseX - (t.dotSize / 2));
          }

        t.focuslock_coords = focusX + '|' + focusY;
        t.focuslock_mouse_coords = centeredMouseX + '|' + centeredMouseY;

        });

      },

      attachment_id: null,
      image_wrapper: null,
      editing: false,
      focuslock_coords: null,
      focuslock_mouse_coords: null,
      dotSize: 22,

      get_focus_points: function() {
        $.post( ajaxurl, {
          action: 'get_focus_points',
          attachment_id: t.attachment_id
        }, function( rsp ) {
          var coords = rsp.focuslock_mouse_coords.split('|');
          t.createDot(coords[1], coords[0]);
        });
      },

      setEdit: function(editing) {
        t.editing = editing;

        if (editing) {
          t.image_wrapper.removeClass('locked');
          $('.edit-focuslock').hide();
          $('.save-focuslock, .cancel-focuslock').show();
        } else {
          t.image_wrapper.addClass('locked');
          $('.edit-focuslock').show();    
          $('.save-focuslock, .cancel-focuslock').hide();     
        }
      },

      createDot: function(top, left) {
        t.image_wrapper.append(
          $('<div></div>')
          .addClass('focuslock-dot')
          .css('top', top + 'px')
          .css('left', left + 'px')
          .css('width', t.dotSize + 'px')
          .css('height', t.dotSize + 'px'));   
      },

      moveDot: function(top, left) {
          t.image_wrapper.find(".focuslock-dot")
          .css('top', top + 'px')
          .css('left', left + 'px');    
      },

      save: function() {
        $.post( ajaxurl, {
          action: 'save_focus_points',
          attachment_id: t.attachment_id,
          focuslock_coords: t.focuslock_coords,
          focuslock_mouse_coords: t.focuslock_mouse_coords
        }, function( rsp ) {

          $('.saved-message').fadeIn('fast');
          setTimeout(function() {
            $('.saved-message').fadeOut('fast');
          }, 2000);
        });       
      }

    });

    t._construct();

    return t;
  }

  // initialise
  window.focuslock = new focuslock();

})(jQuery);