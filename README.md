# Massachusetts-surf
This website is going to display all the information I need to figure out where &amp; when to surf (around Massachusetts).  Additionally I will eventually add sub-pages with more information about each spot, such as a gps map, some graphic annimations, and tide charts.

INFO ON HOW WEBAPP WORKS:

This webapp has a MySql backend that is updated 2x per day with a cron job.  The updateDB.php file and updateImages.php scripts are run to update the MySQL database.  They get their data from the MSW API, parse it, and reformate it for my MySQL database.

When pages are loaded for the client in the webbrowser, the data is taken from the MySQL database. GetData.php does this. Images are stored in the image folder, not in the mySQL database to not slow down the database. GetData.php also does this.

The FrontEnd.js file contains the UI mechanics for the buttons and formating the barGraphs etc.  The data for the barGraphs in the page is taken frmo the mySQL database using getData.php

The folder structure in Git is very similar to that on my actual server so that I can use git for version control.

MySQL INFORMATION:

In case of database issues, the notes file contains mySQL code to reset the database tables.


PLANS FOR FUTURE:

Now that I have a stable backend, I believe it will be much easier to add additionaly functionality from separate API's and maintain organization.  Next I would like to create subpages for each spot, and add some simple additional functionlity to it.

Also I will look into cross-site cookie request issues and see how I can resolve this.

--accomplished this.  Now there is a subpage for each spot, with NOAA tide data. There's hourly tide heights for the current day, then high and low times and heights for the next 5 days.  Additionally I use the googleMaps API to display a satillite image of each spot, giving the user some understanding of how the break works.  Additionally I may add an underwater elevation/contour map eventually.
