# twitter-php-likes-tracker
Tracks liked tweets of a Twitter user via web-app using Twitter PHP API &amp; MySQL.
## Requirements
1. A Web Server with PHP 5.1+ and MySQL installed
2. OAuth Access Token, OAuth Access Token Secret, Consumer Key and Secrets for Twitter Application (https://apps.twitter.com)
## Usage
1. Edit `config.awz.php` to your configuration, including Database Connection.
2. Visit `index.php` to view already tracked liked tweets of the default user, or `index.php?u=USERNAME` for the desired username.
3. Press [UPDATE] to track the newly liked tweets of that user, or directly go through `update.php?u=USERNAME`.
## Remarks
* You can only track public users and protected users you are following.
* There're rate limits so make sure to update periodically instead of real-time tracking.
* The first likes' update of each user will be treated as 'Initial'.
