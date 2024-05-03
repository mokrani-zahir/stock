## Projet Gestion de stock

Projet pour universite abderrahmane mira bejaia pour un Module AIE

### Comment fair functionnée sur votre machin

Prérequis
 - PHP 8.1 ou plus
 - Dirve sqlite3 (Windows posed nativemente) 

Il faut accéder au répertoir de projet est execute c'est command

Pour les base de donnée (migrateion)

``` cmd
php artisan migrate --seed
```

Remarque le flag --seed est optionnel

Pour lance le program (server)

``` cmd
php artisan serve
```

vous acced sur le lien affiche dant le terminal (CMD)

``` url
http://127.0.0.1:8000
```

### Comment verifier si PHP install sur la machin et sa version

Execute cet command dant terminal (CMD pour windows)

``` cmd
php -v
```

Si vous avez ce résultat, c'est bien. Sinon, [télécharger](https://www.php.net/downloads.php 'PHP') PHP et installez-le sur votre machine.
vous pouvez utilisez [WAMP](https://www.wampserver.com/ 'Wamp') ou [XAMPP](https://www.apachefriends.org/fr/ 'XAMPP')

```
$php -v
PHP 8.3.6 (cli) (built: Apr 24 2024 19:23:57) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.3.6, Copyright (c) Zend Technologies
with Zend OPcache v8.3.6, Copyright (c), by Zend Technologies
```

### Remarque de security
L'application n'a pas sécurisé. je v'ai donnée quelque vulnirabilte et leur correction sans implimenter dant le depot gitHub

[CVE-2000-0884 UNICODE](https://nvd.nist.gov/vuln/detail/CVE-2000-0884 'unicode')

[CVE-2023-37635 Brute force attacks](https://nvd.nist.gov/vuln/detail/CVE-2023-37635 'login')

Correction : 

#### CVE-2023-37635 Brute force attacks
 - Il faut implémenter [Login Throttling](https://laravel.com/docs/5.7/authentication#login-throttling 'login_Throttling')

#### CVE-2000-0884 UNICODE

 - Pour CVE-2000-0884 Fair attantion au lib/packer install (en general leur version)


## License

[MIT license](https://opensource.org/licenses/MIT).
