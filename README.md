Lyra CMS
========

A content management system made with symfony 1.4 and Doctrine. Under development and still experimental.

Currently the repository reflects the structure of a standard symfony application. Some modules will be refactored as plugins and eventually placed in their own repositories.

If you are interested to preview and test Lyra, here are simple instructions to install the application in a *local host* development environment. Only tested with Linux, Windows users will need to make adjustments required by their OS.

1.  Create the project folder. For example:

         $ mkdir -p /home/%username%/lyra
         $ cd /home/%username%/lyra

    All subsequent shell statements must be executed from inside this folder, since now on we will refer to it as `%project_dir%`.

2.  Clone the repository

         $ git clone git://github.com/mgiagnoni/LyraCMS.git .

    Do not forget the trailing `.` (dot) as you are cloning into the current directory.

3.  Create log and cache folder.

    As these folders are not included in the repository you need to create them.

         $ mkdir cache log

4.  Install framework

    If you have a client Subversion installed you can checkout a copy of the framework from symfony 1.4 repository

         $ mkdir vendor
         $ svn checkout http://svn.symfony-project.com/tags/RELEASE_1_4_8 lib/vendor/symfony

    Alternatively you can download (http://www.symfony-project.org/installation) the compressed archive (tgz or zip) and uncompress it inside `lib/vendor`: the folder `symfony-1.4.8` that will be created, must be renamed as `symfony`.

    To verify that the framework has been correctly installed execute the following statement (be sure that `%project_dir%` is the current directory):

         $ php symfony -V

    The symfony version must be displayed.

5.  Create database

    With your favorite MySQL administration tool create a main database, a test database (optional, but recommended) and, unless you prefer to use MySQL `root` user, an user with all privileges on both databases. Assuming that you have created a `lyra_user` (with password `%userpassword%`) and `lyra`, `lyra_test` databases, run the following commands:

         $ php symfony configure:database "mysql:host=localhost;dbname=lyra" lyra_user %userpassword%
         $ php symfony configure:database --env=test "mysql:host=localhost;dbname=lyra_test" lyra_user %userpassword%

6.  Build database and load fixtures

         $ php symfony doctrine:build --all --and-load

7.  Final steps
    
    Run the following commands to complete application set up:

         $ php symfony project:permissions
         $ php symfony plugin:publish-assets
         $ php symfony cache:clear

8.  Configure virtual host

    Follow the instruction you will find in chapter *Web Server Configuration* (http://www.symfony-project.org/getting-started/1_4/en/05-Web-Server-Configuration) of the official *Getting Started* guide to configure a virtual host with Document Root `%project_dir%/web`.

9.  Launch application

    Frontend

    > http://lyra.localhost/index.php/

    Backend

    > http://lyra.localhost/backend.php/
    
         Username: admin
         Password: admin

    Replace `lyra.localhost` in both URLs with the *ServerName* you have choosen in virtual host configuration.

