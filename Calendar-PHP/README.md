GRAFIKART.FR

Calendar Part1:

In this project we’re gonna create a calendar which shows the day of the month & we are able to add different events to the calendar, modify them & delete them

In this project we’re gonna use bootstrap for styling

The main page which contains the calendar -> index.php

We create the src folder which raise the security by not bein accessible for the public 
The source folder (src)
src/Date
src/Date/Month.php

For starting the php local intern server (in the terminal)
-> php -S localhost:8000 -d display_errors=1 -t public
Public -> Name of the folder of the project
In the browser for accessing to the server we type: localhost:8000

Namespace: like the shelves which classify the document and should be as same as the folder name. & When we want to user this class for creating a new object we should write: 
Ex: $month = new App\Date\Month;
The classes need to be called
Require ‘../src/Date/Month.php’;

There’s sth very important to be careful about, in Month class we use Exception class which is the PHP native class & as we defined namespace for this native class we should define the namespace also for the Exception class which is used in the Month class 
So we need to clarify to php that Exception() class doesn't come from App\Date class But it comes from the root class
