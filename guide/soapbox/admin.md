# Administration

## Admin Panel

Soapbox has an admin panel built in which can be accessed by going to the admin
route for your site (blog/admin by default).

The admin panel does access control by using the [Auth::File] driver so you will
need to set your user/password in a auth configuration file for your application.

## Post Content

By default, soapbox expects that the text you enter in as the content for a post
is valid html. The text is not changed in any way before it is saved to the
database.