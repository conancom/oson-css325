# Oson-Music Streaming

This is a music player webapp, for the CSS 325 class.

## General Info

Back End : PHP 

Front End : Vanilla CSS & Bootstrap & JS

Database : MySQL

## Implementations

The Login and Logout functionality is made simply using the `SESSION` variable type. 

Songs and Images are stored locally as their corresponding ID, when called strings are concatinated. 
<pre>


Example : songimg/ `songid` .jpg 
          song/ `songid` .mp3
</pre>
       
To retrieve Data for each user, being Artists and Listeners SQL queries are used and called by each page's PHP script.

While also having triggers when follows or unfollows happen to either an Arist or Album.

AJAX is used as the main cog for the search function of Songs, Artists, or even Albums.

The Player itself for the Listener uses Vanilla Javascript and is modified to have a PHP script embedded as well. 

## Final Notes

This is one of our first projects we have done that fully functions, therefore mistakes and errors will be present. 

Any feedback for improvement is always welcome.
