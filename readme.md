Grabs configuration files and prints out database backup scripts.

## Usage examples

General usage

 * `php -f config.php ./wp-config.php`
 * `php -f config.php /home/user/public_html/wp-config.php`


## WP Grabber

Grabs WordPress configuration file

 * `wp ./wp-config.php`
 * `wp /home/user/public_html/wp-config.php`


## Output

```
mysql -hlocalhost -uUSERNAME -pPASSWORD DATABASE
mysqldump -hlocalhost -uUSERNAME -pPASSWORD DATABASE > DATABASE.dmp
gzip -9 DATABASE.dmp
```
