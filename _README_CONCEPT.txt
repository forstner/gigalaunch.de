====== mobile Web Platform Template (mWPT) (gigalaunch) ======

===== ABOUT/DESCRIPTION =====

What is this all about? Video explanation:

<http://www.youtube.com/watch?feature=player_embedded&v=1ad9jbJsdKk>

gigalaunch is a online platform template,
that allows you to get started fast with building your

dream-web-platform with the purpose (i hope so)

to foster peace and collaboration between earthlings and to make this world a better place.

gigalaunch is a online platform template, that allows you to get started fast with building your dream-web-platform with the purpose (i hope so) to foster peace and collaboration between earthlings and to make this world a better place.

demo: <http://gigalaunch.de>

==== FEATURES ====

- linux-style usermanagement (passwd table, groups table)

- easy exchangable backend language+database

- centralized config file config/config.php like the "registry"

- 100% mobile device compatiblity (usage of jquery mobile, even kind of works with older smartphones (blackberry 8900))

- watch passwords be client-side md5 encrypted BEFORE sending them over network (no matter if https or not)

===== CONCEPT ======

1. keep things ASAP - as simple as possible - leave the creators room for their ideas.
2. modulize - 10000 lines of code? split them in reusable modules.

==== client server communication ====

communication is done with json. (object-format: {key1:value1,key2:value2,key3:value3} )

php and jquery-javascript can de- and encode json and i bet almost all server side languages can do this natively with one command. (without you having to write extra code) 

all client-UI-code is client-side generated, there is no server-side generated UI(html) code returned from the server (besides the static (html,js,css) files).

why?
1. to keep things simple (otherwise it might be confusing)
2. to minimize bandwidth usage (better ship data instead of generated-html)

==== clients ====

=== flash ===

could be a client, but not tested, can be easily implemented (featuring xml <CDATA stuff)

=== javascript ==

this is right now the featured front-end technology but other frontends can be implemented because all server-service-requests are defined as "interfaces".

==== server-side ====

gigalaunch wants to maximize your flexibility when it comes to backends and frontends.

backend-wise gigalaunch follows the idea of
"give the server a defined set of commands, and i don't care in what programming language they are implemented in".

my implementation is in php, because it's easy and fast going to setup and debug.

but there are plans for implementations in ruby, python, java or even c / c++ when the concept is tested and worked out.

these service-commands allow frontend's (ajax, javascript, jquery, flash) to easily interact with a mysql-webserver.

every backend that implement the defined set of commands is "gigalaunch" compatible.

you can freely choose your database layout, but i follow the linux-pattern of passwd for users etc.

===== 1. SECURITY: =====

1.1. database credentials: all database credentials are saved in a server-side config.php which will display nothing when called by a browser.

1.2. data theft: there is nothing binary "closed" in javascript, it's all visible "open" source :)
so there is no 100% protection against competitioners that want to steal your data. (e.g. user-list and e-mails)

so here is a little obstacle for skilled programmers.

the transmission of data can be encrypted with a user-defined password. (it will be present on server-side as clear text in config.php and cleartext/encrypted on client-side, inside the javascript embedded into html)

but skilled programmers will simply copy your website (including the front-end-password), change the code, and start calling your backend with their version of your site, and possibly retrieve your data and unencrypt it.

http://mdp.github.com/gibberish-aes/gibberish-aes-test.html

protocol: JSON, XML, CSV

===== 2. COMMANDS/STATUS =====

1.0 login/implemented
determines if a user is allowed to enter/access certain pages.
some pages may be visible to all users (guests) other pages will be only visible to $allowusers = "all logged in users"
or only users of a specific group or only specific users.
who has access to what page, is decided on a per-page-basis, with the $allowedusers and $allowedgroups feature.

... sends username + password (md5 encrypted) to server, server checks if such a username + password exists in the auth-table defined in config/config.php.

2.0. user management
2.1. useradd
is used for two things: 1. user registration by guests 2. creation of new users by admins

2.2. useredit
as usual, the user can per default only edit his/her own details, if the user is in the groups admin, he can edit all other users.

2.3. userdelete
people have the freedom to forget/delete their private data.

2-4. userexists
checks if a given username allready exists.

because this is all done via the same form/mask and you don't want to have 10x forms that you have to edit
if you want to add editable properties to the user.

3.2. data operations

2.2.1. write

2.2.1.1. write paging (allows writing of large amounts of data step-by-step wise, because 
php/webservers/internet has timeouts!)

2.2.2. change

2.2.2.1. change paging

2.2.3. read

2.2.3.1. read paging

===== 3. USECASES =====

what (default) functions (use-cases) the user should be able to do with this platform.

1. view informations (search)

2. upload information: you enter information, you select pictures, maybe you edit pictures, than upload them.

3. change information: you need a new password

4. delete information: you want to delete your account

... all this can be put into a tree structure.

... pictures will be uploaded as files, not saved in database.

===== 4. MODULAR TESTING =====

if you created a new page/module you can test it without going through all the login->buttons->to-your-module

by simply comment-out this line:

// require_once('./lib/php/lib_session.php');

Questions? -> Message: https://sourceforge.net/sendmessage.php?touser=4169280

==== Group Management ====

the database-concept behind groups is like this:
1. there is a column in the passwd table which contains a comma-separated list of all groups that the user belongs to.
2. the table groups contains all available groups, you can add your own column-properties.

====== GIT REPOSITORY ======

you can get source-access only via git (sry)

git clone git://git.code.sf.net/p/gigalaunchde/code gigalaunchde-code

how to import project into eclipse: <http://www.youtube.com/watch?feature=player_embedded&v=xxEOJxRxbOY>

====== DEMO ======

http://gigalaunch.de/

==== HOW TO CONTRIBUTE / WRITE ACCESS ====

i would love to see this project flourish and get new goodies,

i have a VirtualBox VM
+ based on Debian-Gnome
+ pdt-eclipse
+ git ready configured (with gigalaunch repositories)
+ xdebug
+ lighttpd working

and i am willing to provide it as a (big) download.

but saves you all the development environment setup shit and it's so nice to have a step-debugger on board.

if you want it send me a message: https://sourceforge.net/sendmessage.php?touser=4169280 

if you need write access

1. signup at sourceforge.net
https://sourceforge.net/user/registration

2. send me a message/please contact me! via mail: jmi21@gmx.de
https://sourceforge.net/apps/trac/sourceforge/wiki/Git%20permission%20management

3. upload your public ssh key (admin area of your profile)	
