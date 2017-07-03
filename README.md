# twitter-php-likes-tracker
Tracks liked tweets of a Twitter user via web-app using Twitter PHP API &amp; MySQL.
## Requirements
1. A Web Server with PHP 5.1+ and MySQL installed
2. TwitterAPIExchange.php from https://github.com/J7mbo/twitter-api-php/blob/master/TwitterAPIExchange.php
3. OAuth Access Token, OAuth Access Token Secret, Consumer Key and Secrets for Twitter Application (https://apps.twitter.com)
## Installation
1. Execute `twt.sql` on [twt] database or your desired name.
2. Edit `config.awz.php` to your configuration, including Database Connection.
## Usage
1. Visit `index.php` to view already tracked liked tweets of the default user, or `index.php?u=USERNAME` for the desired username.
2. Press [UPDATE] to track the newly liked tweets of that user, or directly go through `update.php?u=USERNAME`.
## Remarks
* You can only track public users and  **protected users you are following**.
* **There are rate limits** so make sure to update periodically instead of real-time tracking.
* The first time update of each user will be treated as 'Initial'.
