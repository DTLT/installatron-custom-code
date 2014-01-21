Installatron Custom Code
========================

We use the [Installatron](http://installatron.com/) plugin with the Domain of One's Own project to provide an easy way for users on the system to install a variety of open-source software. Installatron has [great documentation](http://installatron.com/developer/customization) for customizing the install process and hooking into that functionality which we've used to setup packages of plugins and themes in Wordpress as well as write install information to a separate community Wordpress install.

This code uses [FeedCache](https://github.com/erunyon/FeedCache) to store the contents of a Google Spreadsheet to a local file for faster access. That spreadsheet has columns for Course Name, Instructor, and Course Code which populates a dropdown form as part of the install process for students to identify whether the install is related to a course.
