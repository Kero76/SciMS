# SciMS
SciMS is an CMS like to post research article. In fact, thanks to SciMS, you can create really easily a website in few step.<br>
You can administrate the website with an administration panel. Many persons can registered on SciMS and collaborate to write research articles.<br>
SciMS have an editor WYSIWYG to help the redaction of the article and support LaTeX and MathML syntax to render a good mathematical formula.<br>
So, let's go, install and use SciMS to develop your scientist blogs.

## Installation
### Process to install SciMS
1. Clone or download SciMS sources.
2. `$ cd SciMS/`
3. `$ composer install` to download external librairies dependency.
4. After the download of all librairies dependency, send the following folders on your server :
    * app/
    * src/
    * vendor/
    * views/
    * web/
5. Now, you can access at your future website on type :
`http://domain_name/web/index.php`.<br>
An installation screen appear, type all information required :
    * DNS : The DNS of the database.
    * Database name : The name of the database.
    * Database username : The name of the user can interact with the database.
    * Database password : The password of the user can interact with the database.
    * Email of the future website administrator.
    * Username of the future administrator.
    * The password of the future administrator.
6. After these form, you must redirect on the home page and you can administrate and using your website.

### Optional features
Before send all folders on the server, you can modify settings.yml file present on /app/.
In fact this file include some feature can personalize by yourself :
* title : The title of the website.
* subtitle : The subtitle of the website.
* website_authors : The author of the website.
* copyright : The footer of your website.
* last_article : The number of article available on the home page.
* article_status: Coming soon.
* user_role : Coming soon. 
* abstract : The number of character displayed on abstract on homepage, because the abstract element can huge and it truncate at XXX characters.
* theme : If this attribute is empty, you don't use theme. So to fill this attribute, check the file themes.yml for add a theme.

## Features
* Installation directly without modified settings files (See Installation part above).
* Website registration with unique email, username and password.
* Website connection thanks to email.
* Roles for users :
    * Visitor : Not register on website and can only consult article, article by category, user profile and research articles or users on website.
    * Register : A registered user can write, edit and delete his articles and update his user profile.
    * Administrator : The creator of the website (only one by website). It can create, update or delete a category and update or delete all users registered except itself.
* TinyMCE integration :
    * Write LaTex math.
    * Write on MathML.
    * Source code coloration (C, C#, C++, Java, Python, Ruby, HTML, CSS, JavaScript and PHP).
* Website settings are stored on Yaml file in the /app/ folder.

## Prerequisites
* JavaScript must activate on your favorite web browser, because TinyMCE and many others scripts use JavaScript to execute.
* Composer must install to download libraries dependencies.

## Authors
You can contact authors on the following email address :
* Nicolas GILLE (aka Kero76) <nic.gille@gmail.com>
* Grégoire POMMIER (aka TeeGreg) <gregoire.pommier@etu.univ-rouen.fr>

## External Links
### SciMS
* Try the application thanks to the following link : [SciMS](http://scims.nicolas-gille.fr/web/index.php)

### Documentations
#### Languages manual
* W3School : [http://www.w3schools.com/](http://www.w3schools.com/)
* Manual PHP : [https://secure.php.net/manual/fr/index.php](https://secure.php.net/manual/fr/index.php)

#### Framework manual
* The Framework Rhapsody create by Kero76 : [https://github.com/Kero76/Rhapsody](https://github.com/Kero76/Rhapsody)
* The framework Bootstrap : [http://getbootstrap.com/](http://getbootstrap.com/)
* The icon framework Font-Awesome : [http://fontawesome.io/](http://fontawesome.io/)

#### Templates engine
* The template engine Twig : [http://twig.sensiolabs.org/](http://twig.sensiolabs.org/)

#### JavaScript Libraries
* The JQuery API : [http://api.jquery.com/](http://api.jquery.com/)
* The WYSIWYG Editor TinyMCE [https://www.tinymce.com/](https://www.tinymce.com/)
* The Mathjax librairy to interpret LaTex and MathML tags on TinyMCE : [https://www.mathjax.org/](https://www.mathjax.org/)

### Tools
* The package manager Composer : [https://getcomposer.org/](https://getcomposer.org/)
* The service Gravatar [not implement]: [http://fr.gravatar.com/](http://fr.gravatar.com/)
* The Yaml extension from Symfony : [https://symfony.com/doc/3.1/components/yaml.html](https://symfony.com/doc/3.1/components/yaml.html)

### Links
* A good practice to develop with PSR-X : [http://severin-bruhat.com/blog/php-bonnes-pratiques-et-conventions/](http://severin-bruhat.com/blog/php-bonnes-pratiques-et-conventions/)
* A large article to help with PDO operations : [https://phpdelusions.net/pdo](https://phpdelusions.net/pdo)
* An article to manage Composer dependency : [http://www.umanit.fr/En-ce-moment/UmaNotes/Gerer-ses-dependances-PHP-avec-Composer](http://www.umanit.fr/En-ce-moment/UmaNotes/Gerer-ses-dependances-PHP-avec-Composer)
* A list of all packages available with Composer : [https://packagist.org/](https://packagist.org/)
* How to write a composer.json file : [https://getcomposer.org/doc/04-schema.md#json-schema](https://getcomposer.org/doc/04-schema.md#json-schema)
* Yaml explanation : [http://sweetohm.net/article/introduction-yaml.html](http://sweetohm.net/article/introduction-yaml.html)
* A website to test Regular Expression : [https://regex101.com/](https://regex101.com/)
* An article to see more information about URL Rewriting : [https://craym.eu/tutoriels/referencement/url_rewriting.html](https://craym.eu/tutoriels/referencement/url_rewriting.html)
* You search a specific icon : [http://glyphsearch.com/](http://glyphsearch.com/)
* More information abouts all themes available on SciMS : [https://www.bootstrapcdn.com/bootswatch/](https://www.bootstrapcdn.com/bootswatch/)
