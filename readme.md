# bet-it-back

**1- packages installation**

 ```composer install```

**2- configur your .env**

 

**3- update database schema**

 ```php bin/console doctrine:shema:update --force```
 
 **4- fetch data**
 
```php bin/console doctrine:fixtures:load```
