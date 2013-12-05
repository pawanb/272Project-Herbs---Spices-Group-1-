<?php die();?>

# don't show the replay & quote buttons if user is not allowed to post
# No email was sent to moderators when autopublish comment was turned on
+ added cobalt plugin
# the general import script had an error in it
# updated CB user comments plugin
# not all CB plugin were installed with the package
# added new jomsocial plugin to render the activity stream (works on jomsocial > 2.8)
# youtube video now respects the url scheme (http/https)
# some language strings were missing from the language files
# getELement (...)' is null or not an objet on line 250 character 5 on media/com_comment/us/views/comments-outer.js
# placeholder not showing on IE
+ added placeholder support for browsers that don't support placeholders
+ added smart search plugin
+ added search plugin
# the latest comment module was not part of the PRO package
# the k2 plugin was causing JForm::getInstance not found on some installations in k2 items
# anonymous was not translatable in the javascript files
# joomla 3.1.4 has a bug and is unable to load the JHtml class if it is written in any other way than JHtml (JHTML, jhtml was invalid)
+ added option in the template to auto show the name and email fields
# the comments module was showing comments that were unpublished
+ added gpstools plugin
+ added communityquotes plugin
# fixed fatal error when the module was enabled on kunena pages
# fixed an issue with comment crawling
# nested comments - moderators only was not working as expected
# thumbs move down/up - thanks Josh!
+ AUP improvements - showing a message about the activity the user performed
# HWD plugin was not installed properly
# added margin to .ccomment-replies for templates that set the margin for uls to 0
# comments were not showing up in HWDMediashare
+ added AUP integration - user points are now assigned on comment & vote
# possible fix for - require.js was not loaded
# fixing bug with import from jcomments
# comment needs moderation was not visible when we were replying to nested comment
# unpublished comments were shown when they were nested
+ added plugin for Communitypolls
# groupHasAccess was producing a notice if the second argument was not an array and that way breaking the component
# the cancel button in the template was not translated
+ added redshop plugin
# using overrides/new template located in your_template/html/templates was causing an error
# could not delete comments on some servers
# no message was output when the user comment needed moderation
+ added support for kunena profiles
+ added support for kunena avatars
+ added Zoo plugin
# optimised performance when working on the mail queue
+ added back the docman plugin for docman 1.6.4
# html errors in the template
# the installed version number was not visible in the backend
# too long words were not wrapped...
# fixing problems with the resizing of the textarea
+ added plugin for dpcalendar
+ added option to add the comments using the onContentPrepare event for com_content
# fixes issue with update from 4.2.1
# fixes issues with content tag {ccomment on|off|closed}
# captcha issues with selected group on j2.5
# update from 4.2.1 was not properly executed
# captcha usergroup selection was not having any effect
# k2 plugin was missing from the pro package
+ added plugin for hikashop
# comment system was not working properly when cache was on
# "use names" option was not working properly
# k2 plugin was not installed with the core version
# when the article is closed for further comments change the "write comment(x comments)" button to just "x comments" in list view
# joscomment plugin recognises {ccomment on|off|closed} tag
# comments were not loading on IE8
# k2 plugin was not installed in the correct plugin group
# uninstallation was not removing some plugins
# comments were not displaying when the user was not authorised to post
+ emails are now sent either on page load or per cron job
+ added plugin for com_matukio (Matukio - Event management)
# url in notification mail is wrong for https sites
+ added com_joomgallery plugin (check docs for more info)
+ added com_jdownloads plugin (check docs for more info)
# write comment was not shown on category blog view for com_content
# the link to docimport didn't have an itemId
# wrong username was shown in comment list in the backend
# textarea was not expanding when the quote was bigger than the textarea
# module was not able to show the comments from multiple components
# use the setLimit for comments in the module properly by respecting the bbcode
# css fixes for embeded youtube videos
# fixing problem when updating from 4.2.1 & and a language translation is installed
# quote & edit were not working
# some buttons were not clickable on the Ipad
# fixed issue 67 smilies break on vote
+ implemented ajax crawling according to google's specification. Now comments should be indexed by search engines
# wrong license tag in few plugins
# missing JEXEC statement in few files
# posting comment as logged in user was not working
# fixing a problem with reply to a comment
# now scrolling to the comments only if we have the correct hash
# settings were not correctly saved after the install
# bug fiexes for IE6
# bug fixes for IE8
+ added plugin for Docimport
# fixed a problem with joomla's SEF :(
+ added HWDMediashare plugin
- removed docman integration
- removed hwdvideo and hwdphoto integration
# updated LiveUpdate library
+ added jcomments, komento & disqus import
+ added fb like on dashboard for compojoom.com
+ added dashboard
+ added an indicator when loading comments
+ making the form a little more user friendly on submit
+ output error messages to the user submitting a comment & validate form input
# updated virtuemart plugin
# updated ninjamonial plugin
# updated the jphoto plugin
# updated jevents plugin
- removed com_eventlist plugin as the extension is no longer supported
+ cb plugins are now installed during the ccomment installation
# updating the com_comprofile plugin and adding the ccomment wall plugin for cb
# updated adsmanager plugin
# updated the easyblog plugin
+ adding the k2 and Hotpsots plugins to ccomment5 Core
# updating the hotspots plugin
# updating the phocadownload plugin
# could not delete settings in backend
- removing JomsocialGroup & JomsocialGroupDiscussion plugins
# updated the jomsocial wall plugin
# wrong message shown when comments were set to autopublish
# fixing a warning when no moderator group was selected
# one was not able to create new plugin settings
+ add support for like & comment on the jomsocial activity stream
# updated our jomsocial plugin
+ adding the bare minimum of bootstrap CSS so that the template can be displayed properly on sites that don't use bootstrap
# css class was not properly added to comment
# display component name when editing/creating a new stting
=======================
# fixing the backend CSS on joomla 2.5 (it doesn't come with bootsrap....)
+ uninstall now works properly
# we are no able to properly update from 4.2.1
+ we are now able to select which user group has the right to post comments
~ updated the K2 plugin
- removed the stringparser library as it is no longer used
# fixes for joomla 2.5
# show pagination only if enabled
# the DS constant is not available in j3.0
# selecting all comments to delete was not working in backend
# fixed strict standards warning when using jomsocial avatars
- removed legacy install/uninstall procedures
- removed plugin for sobi2 as the extension is not supported on joomla 2.5
- removed plugin for seyret as the extension is no longer supported
- removed plugin for puarcade as the extension is no longer supported
- removed plugin for jomtube as the extension is no longer supported
- removed plugin for mmsblog as the extension is no longer supported
- removed plugin for myblog as the extension is no longer supported

CComment 5.0a1
================================================================================
~ simplified backend
+ joomla 3 support
+ Closely follows Joomla MVC conventions
+ new template engine
+ new default template based on bootstrap markup
+ new bbcode engine supporting video, automatic link, code highlighting
+ author of article can be moderator
+ new email templates
+ one click publish/unpublish comment from email
+ one click unsubscribe from future notifications of new comments
- removed legacy code - functions, templates (40k lines of code)