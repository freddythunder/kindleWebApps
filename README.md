# kindleWebApps
Rudimentary web based applications for Kindle's experimental web browser.

I recently bought a Kindle Scribe to better my personal and professional 
workflows.  Through the years I have written notes with pen and paper 
at my desk or creating sketches for 3d printing, but have always 
wanted to get away from actual paper.

# Limitations
When I originally started making this into a more normal looking application, 
I started running into a lot of limitations with the Kindle's experimental
browser.  There is no JavaScript at all, no events, no external stylesheets, 
not much to work with.  If you see something that looks like it's not the way 
we do things now, it might be because it had some issues in the browser.

# Installation
As it stands, there's only a few modules created.  This serves as a good starting 
point as I continue to make modules.  You're free to download and do whatever 
you'd like.  There are a couple things you need to know:

```apacheconf
<Directory /path/to/your/kindle/app/>
	SetEnv DBHOST 127.0.0.1
	SetEnv DBNAME [database name]
	SetEnv DBUSER [database username]
	SetEnv DBPW [database password]
	SetEnv MAILHOST [SMTP host]
	SetEnv MAILUSER [Mail username]
	SetEnv MAILPW [Mail password]
</Directory>
```
I have been putting credentials for things in the apache2.conf file instead of a 
config file in the rest of the filesystem.  That way I won't accidentally explose 
creds into github or whatever.  If you don't know how to do this or don't want to 
mess with config files, you can hardcode anything that has $_SERVER in the codebase.

If you plan on using a part of the app that sends emails to your Kindle, you will 
have to have PHPMailer loaded up in composer.  I have been using zoho mail for a 
while now and it's been working pretty well.  I used that to send crosswords to 
my kindle.
```
$ composer require phpmailer/phpmailer
```
To successfully send emails from your server to your kindle, you'll have to go
here https://www.amazon.com/hz/mycd/myx#/home/settings/payment, Personal Document Settings 
on the bottom and make sure you have the proper @kindle.com address and the
Approved Personal Document E-mail List has the address (or @domain.com for 
wildcard) to come from your STMP or mail server if you go that route.

# SongList
This will fail for you because it is going to connect to a database that's 
not there and tables that aren't created.  I'll put an SQL up soon to 
simulate what I have and change this comment when I do.  So if you're reading 
this, I haven't done it yet.

# GoogleTranslate
Years ago I remember I was able to curl from the command line to google and 
get translations out rather easy.  But it looks like they figured that out 
because the AJAX calls are not as easy as they were.  There's a python 
google translate class out there, but I couldn't get that to work.  The paid 
version of google translate API is not the easiest, so I will have to get 
back to this.  Maybe use a different translator service.

# Files
This will allow you to read .txt, .png and .jpg files that are put into the 
files folder.  I'll probably make this more robust like sizing any images 
in an image tag, but right now it just opens up the file.

# The Future!!
I'm a sucker for puzzle books, the crossword thing is great, but I am going 
to add modules to get sudoku and wonderword puzzles and have them deliver as 
PDFs via email just like the crosswords.