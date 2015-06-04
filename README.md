# WP FocusLock

![Neota Tech](https://raw.githubusercontent.com/Boztown/wpfocuslock/master/extra/neota-tech-logo.png)

WP FocusLock is a WordPress plugin for adding responsive focal points to images.  It's essentially a wrapper for https://github.com/jonom/jquery-focuspoint with an admin interface for setting where the focal point is.

![WP FocusLock Animated Example](https://raw.githubusercontent.com/Boztown/wpfocuslock/master/extra/mushroom-gif.gif)

For a better idea of what this does check out this demo from the jQuery FocusPoint repo: http://jonom.github.io/jquery-focuspoint/demos/helper/index.html

## Adding a Focus-locked image to a theme or content

### Shortcode

```
[focuslock_image id="<attachment_id>" size="large" classes="feature-image rounded" width="100%" height="500px"] 
```

### Function Call

For a permanment fixture in a theme:

```
<?php focuslock_image(135, 'large', 'guy'', '100%', '500px'); ?>
```

An example of using an attachment ID from an ACF photo field:

```
<?php focuslock_image(get_field('photo'), 'large', 'guy'); ?>
```

An example of using the post's featured image:

```
<?php focuslock_image(get_post_thumbnail_id(), 'large', 'gal'); ?>
```

### Styles

Focused images will naturally adopt a style with a __width of 100%__ and a __height of 450px__.  This default was chosen because a width/height is needed for anything to be displayed at all and this makes for a good example.  You can use the width/height attributes of the shortcode or function to change this.  You can also set an extra class and use CSS to set the dimensions (among other things).
