jQuery(document).ready(function( $ ) {

    $("#focuslock-image-wrapper > img").click(function (ev) {
    mouseX = ev.offsetX;
    mouseY = ev.offsetY;
    console.log(ev);
    //alert(mouseX + ' ' + mouseY);
    var color = '#000000';
    var size = '22';
    $("#focuslock-image-wrapper").append(
        $('<div></div>')
            .addClass('focuslock-dot')
            .css('top', mouseY - (size / 2) + 'px')
            .css('left', mouseX - (size / 2) + 'px')
            .css('width', size + 'px')
            .css('height', size + 'px')
    );
  });
});