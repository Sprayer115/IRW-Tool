# IRW-Tool
Teamprojekt IRW

# Installation

## 1. PHP 8.3.7
https://windows.php.net/download#php-8.3

Neuste Version installieren: https://www.geeksforgeeks.org/how-to-install-php-in-windows-10/ 

(Geht schneller als es aussieht 5 min)

Entkommentieren : 
- "extension=fileinfo"
- "extension=pdo_sqlite"

Falls weitere Fehler bei "composer install" kommen, fehlt meist eine extension bei php.
  
 in php.ini


**----> Restart**
## 2. Composer
https://getcomposer.org/Composer-Setup.exe

**----> Restart**

## 3. Node.js

https://nodejs.org/en

## 4. Git Clone
```
git clone https://github.com/Sprayer115/IRW-Tool
```

# Laravel Setup

## 1. Run it (After every Checkout)
```
cd IRW-Tool
composer install
npm install
php artisan migrate
```
cp .env.example -> .env
## Troubleshoots

***1. No application encryption key has been specified.***
```
php artisan key:generate
```

***2.Cache Clear***
```
php artisan cache:clear
```

## Dev Setup
Webserver:
```
php artisan ser
```

Frontend:
```
npm run dev
```


# Deploy
sudo ./delpoy
sudo env "PATH=$PATH" npm install
sudo env "PATH=$PATH" npm run build