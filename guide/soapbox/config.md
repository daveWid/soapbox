# Configuration

The default configuration file is located in `MODPATH/soapbox/config/soapbox.php`. You should copy this file to `APPPATH/config/soapbox.php` and make changes there, in keeping with the [cascading filesystem](../kohana/files).

Below is a list of the configuration options:

Name | Type | Default | Description
-----|------|---------|------------
title | `string` | My Blog | The name of your blog.
description | `string` | Another Soapbox blog | A short description for your blog (Used in the RSS feed only by default).
section | `string` | blog | The section of the site your blog will live. Setting this to an empty string _("")_ will make your whole site a blog.
per_page | `int` | 10 | The number of posts per page in all/category views.
admin | `string` | admin | The name of the route for the admin panel. You can set this option to make it harder for curious visitors to guess.
