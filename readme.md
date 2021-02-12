# bet-it-back

**1- Packages installation**

 ```composer install```
 
**2- Generate JWT Keys**

 ```
Créer un dossier JWT dans "config/"
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

**2- create & configure your .env.local**


**3- update database schema**

 ```php bin/console doctrine:shema:update --force```
 
 **4- fetch data**
 
```php bin/console doctrine:fixtures:load```
