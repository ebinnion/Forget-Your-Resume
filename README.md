#Forget the Resume

This tool will help non-technical college students to generate profiles to help promote themselves online. As of version 1.0, 
students that use this tool will be able to:

 - Create a resume using a WYSIWYG editor.
 - Enter an about me section using a WYSIWYG editor.
 - Show social networking links.
 - Change the design of their personal website with background images and basic styles.
 - Upload a profile image

#How to Install
Forget the Resume was built for ease of use. Since it is built using SQLite as a database and the base url is set dynamically, all you have to do is *upload the directory* to your server.

<!-- I have created a small video series on Youtube to help you get up and running quickly with Forget the Resume.

- Video #1 - [Domain and Hosting](http://www.youtube.com/watch?v=yOCRl_5TW5s) (Experienced users should skip)
- Video #2 - [Upload Instructions](http://www.youtube.com/watch?v=KVa3QTLESWE)
- Video #3 - [Working with Settings](http://www.youtube.com/watch?v=IboWsUxgSNU) -->

Once you have uploaded the files to your server, you can login by going to the settings page (http://you.com/settings). To login the username and password are both 'admin' (without the quotes). Be sure to update your password after you have logged in for the first time.

If you have issues with your settings not saving, then you will likely need to change the permissions on the /application/db folder so that they are writeable. I suggest trying 755, then 775, then 777 until settings are able to be saved.

#Created By
This tool was created with love by [Eric Binnion][1] to be released on [Art of Blog][2]. This Github repository is meant as a way to store our source code. For more information about the project, visit [Art of Blog][2].

#Colophon
Forget the Resume was built with the help of many other open sourced projects. Below is a list of all of the projects that were used to help build the Forget the Resume.

 - [CodeIgniter][6]
 - [jQuery][5]
 - [jQuery UI][7]
 - [Drought][9]
 - [SQLite][10]
 - [FontSelector](http://lindekleiv.bitbucket.org/fontselector/)

All background patterns are under creative commons and courtesy of [Subtle Patterns][3].

#Licensing
This software is released under the MIT License. This essentially means you have a great amount of rights and can use the software for free. If you find the software useful we would appreciate a link back to [Art of Blog][2].

Copyright (c) 2013 Microbrand Media

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

  [1]: http://ericbinnion.com
  [2]:http://artofblog.com
  [3]:http://subtlepatterns.com
  [4]:http://jhtmlarea.codeplex.com/license
  [5]:https://github.com/jquery/jquery
  [6]:http://ellislab.com/codeigniter/user-guide/license.html
  [7]:https://github.com/jquery/jquery-ui/blob/master/MIT-LICENSE.txt
  [8]:http://codecanyon.net/item/jquery-image-select/3946862
  [9]:https://github.com/jamesfleeting/Drought
  [10]:http://www.sqlite.org/copyright.html