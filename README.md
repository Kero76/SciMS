# SciMS
Creation of CMS like for post research article.

## Installation
1. Clone or download SciMS sources.
2. `$ cd SciMS/`
3. `$ composer install` to download external librairies depedencies.
4.  After installation, fill the file app/database.yml with :
    * dns : DNS of your Database access.
    * dbname : Name of your Database access.
    * user : Name of the user of your Database access.
    * password : Password of your Database access.<br>
    
    and fill the file app/settings.yml with :
    * title        : Title of your website between quote like "My Website"
    * subtitle     : The subtitle of your website, if you have a subtitle.
    * copyright    : The footer content of your website between quote like "&copy; 2016"
    * last_article : The number of article at display on your home page.
    * article_status: An array of all article status possible for your future article.
    * user_role: An array with all role for your future user register.
5. Create the table on the Database with the file database/create_table.sql.
6. Register your account and SciMS is ready to work.

## Features
* Website registration with unique email, username and password.
* Website connection thanks to email.
* Write an article on website and edit it directly when you read it on website.
* Create new categories.
* Consult your user profile and modify information like name, last name, birthday, avatar and many others informations.
* TinyMCE integration.
* Setting website with Yaml settings file on folder app/.

## Prerequisites
* JavaScript must activate on your favorite web browser, because TinyMCE and many others scripts use JavaScript to execute.
* Composer must install to download libraries dependencies.

## Authors
* Nicolas GILLE <nic.gille@gmail.com>
* Grégoire POMMIER <gregoire.pommier@etu.univ-rouen.fr>


## External Links
### SciMS
* Application link : [SciMS](http://scims.nicolas-gille.fr/web/index.php)

### Documentations
#### Languages manual
* W3School : [http://www.w3schools.com/](http://www.w3schools.com/)
* Manual PHP : [https://secure.php.net/manual/fr/index.php](https://secure.php.net/manual/fr/index.php)

#### Framework manual
* Website of Bootstrap : [http://getbootstrap.com/](http://getbootstrap.com/)
* API of JQuery : [http://api.jquery.com/](http://api.jquery.com/)
* Website of Font-Awesome : [http://fontawesome.io/](http://fontawesome.io/)

#### Templates
* Website of Twig : [http://twig.sensiolabs.org/](http://twig.sensiolabs.org/)

#### JavaScript Libraries
* Website of Mathjax : [https://www.mathjax.org/](https://www.mathjax.org/)
* Website of TinyMCE [https://www.tinymce.com/](https://www.tinymce.com/)

### Tools
* Website of Composer : [https://getcomposer.org/](https://getcomposer.org/)
* Website of Gravatar : [http://fr.gravatar.com/](http://fr.gravatar.com/)
* A website to test Regular Expression : [https://regex101.com/](https://regex101.com/)

#### TinyMCE plugins
* LaTex plugin : [http://moonwave99.github.io/TinyMCELatexPlugin/](http://moonwave99.github.io/TinyMCELatexPlugin/)
* Math integration plugin : [http://www.wiris.com/solutions/tinymce](http://www.wiris.com/solutions/tinymce)
* Latex integration plugin : [http://moonwave99.github.io/TinyMCELatexPlugin/](http://moonwave99.github.io/TinyMCELatexPlugin/)

### Links
* An article to manage Composer dependency : [http://www.umanit.fr/En-ce-moment/UmaNotes/Gerer-ses-dependances-PHP-avec-Composer](http://www.umanit.fr/En-ce-moment/UmaNotes/Gerer-ses-dependances-PHP-avec-Composer)
* A large article to help with PDO operation : [https://phpdelusions.net/pdo](https://phpdelusions.net/pdo)
* A list of all package available with Composer : [https://packagist.org/](https://packagist.org/)
* A good practice to develop with PSR-X : [http://severin-bruhat.com/blog/php-bonnes-pratiques-et-conventions/](http://severin-bruhat.com/blog/php-bonnes-pratiques-et-conventions/)
* An article to see more informations about URL Rewriting : [https://craym.eu/tutoriels/referencement/url_rewriting.html](https://craym.eu/tutoriels/referencement/url_rewriting.html)
* Yaml extension : [https://symfony.com/doc/3.1/components/yaml.html](https://symfony.com/doc/3.1/components/yaml.html)

