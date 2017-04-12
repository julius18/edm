# edm-kc
Electronic Direct Marketing for Karma Club

This repo is connected to /var/www/vhosts/karmaclub.com/httpsdocs/edm-kc/

#how to sync the code from this repo to AWS karmaclub.com:
1. Turn off the rsync karmaclub.com in crontab.
2. Pull the code to karma-1a:
   Enter Command: cd /var/www/vhosts/karmaclub.com/httpsdocs/edm-kc/
   Enter Command: git pull https://github.com/karmagroup/edm-kc.git
   Put Username: cloud@karmagroup.com
   Put Password:
3. Pull the code to karma-1b:
   Enter Command: cd /var/www/vhosts/karmaclub.com/httpsdocs/edm-kc/
   Enter Command: git pull https://github.com/karmagroup/edm-kc.git
   Put Username: cloud@karmagroup.com
   Put Password:   
4. Turn on the rsync karmaclub.com in crontab.
5. It will sync the Karma-1a and Karma-1b

Rock & Roll..
Good Luck Team!

#Contributor
Ferry Yudhitama ferry.yudhitama@karmagroup.com
Kadek Ramsyana kadek.ramsyana@karmagroup.com
Last Revision: 12/04/2017 11:05.
