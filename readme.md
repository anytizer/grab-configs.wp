Grabs configuration files and prints out database backup scripts.

## Usage examples

 * `php -f config.php ./wp-config.php`
 * `php -f config.php /home/user/public_html/wp-config.php`


## Output

```
mysql -hlocalhost -uUSERNAME -pPASSWORD DATABASE
mysqldump -hlocalhost -uUSERNAME -pPASSWORD DATABASE > DATABASE.dmp
gzip -9 DATABASE.dmp
```

