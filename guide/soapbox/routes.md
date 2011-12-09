# Built-in Routes

Soapbox provides the following routes for your site by default. These all can be [configured](config).

Route | Description
------|---------
blog  | The main blog page which holds a list of all posts
blog/category/{slug} | A list of posts that are tagged in the given category
blog/{year}/{month}/{slug} | A single blog post
blog/admin | An administration interface (_the admin route can be changed through configuration_)