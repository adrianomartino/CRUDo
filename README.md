CRUDo
=====

------ Intro ---------

Crudo is a PHP-based rapid development framework. 
The final goal is to be able to create websites with lots of content in minutes, with any DB-structure. 
It will also have default views then you can add your views by simply coding html and css.

It was written by me mostly in 2011 with some edits in 2012. I did not use version control or GIT! :-O

I decide today to start working on it again as I believe it might have a shot as an alternative PHP framework.


------ Objectives -------


- Consolidate PHP language by creating new classes and functions to handle the mess
- Provide a system with automatically fewer http requests
- Provide a system that is easily adaptable to different DB structures
- Have a complex website up and running in minutes (provided HTML/CSS has been written)
- Support multiple languages natively
- avoid repetitions thanks to an over normalized database
- Support drafts also for updates
- support multiple user levels (Public, Registered, Author, Editor, Supervisor, Admin, Superadmin)
- Automatically manage and serve the right images for any devices and pixel densities
- Work in a safe environment
- Break it down into loos modules
- Supporting multiple websites
- Have a fast, performant clean code


------- MVC based -------

As of today Models Views and Controllers are in 3 separate folders. I indend to change this structure by having a folder for each feature with its own Controller, Model and View(s).

------- All classes are autoloaded -----

Adding a new Class is as easy as creating a new file. No need to edit anything else for the class to be included


------- Most things are handled to Static methods and CONSTANTS ------

This way the access to each memory slot will be faster. Also the most important info needed at hand in most classes and methods are available right away.


------- 1 Config file to setup your website ------

Most preferences can be handled through 1 config.ini file





------- More info will be added --------
