## What does it do

It's the web interface portion of the asynchronous bitcoin data scraper. It gathers data from a MySQL database and displays it using jQuery and CanvasJS.

## What was the inspiration for the project

To log and monitor the top 1000 most active bitcoin addresses to see if there was correlation between large single address balance/transaction movement and global price movement.

## Install

1) Install monbit3 scraper
2) Install a web server
3) Install PHP

## Setup

1) Move all file to your public web directory (htdocs, www, etc)
2) Open and edit 'api.php', change the config at the top to include your MySQL host, credentials and database name
3) Do the same for the file 'table.php'

## Run

Open your browser and go to http://localhost/?start=0&end=50

The 'start' and 'end' parameters define how many addresses you are selecting from the table and from what point

## LICENSE

GNU GPLv3