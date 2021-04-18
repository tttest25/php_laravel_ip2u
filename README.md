<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Test project for learning

### Phrases
common convention

it just depends

very procedural
step oriented 
clean api

block format




## xdebug
install in docker

``` 
apt update && apt-get install -y iputils-ping netcat
curl https://getmic.ro | bash && mv ./micro /usr/bin
pecl install xdebug

micro /etc/php/8.0/cli/php.ini
add 
zend_extension=/usr/lib/php/20200930/xdebug.so

xdebug.mode=debug
xdebug.client_host=172.19.0.1
xdebug.client_port=9001
xdebug.start_with_request=yes

running XDEBUG on ESL not on local 
test 
 nc -vz 172.19.0.1 9000
````





```bash
$ docker-compose up --build --force-recreate --no-deps -d cryptopro
```

```SQL
-- SQL for testing CSP
create table cspusers(
   cid INT NOT NULL AUTO_INCREMENT,
   userid int,
   serialNumber VARCHAR(100) NOT NULL,
   PRIMARY KEY ( cid )
);
INSERT INTO `cspusers` VALUES (1, 1, '04AEEA81008BAC629A422A6A6871A0F6E0');
```

```PHP
$csp = app("Cspusers");
$csp ->userid=1;
$csp ->serialNumber='04AEEA81008BAC629A422A6A6871A0F6E0';
$csp->save();

 User::factory()->create(['name' => 'Eugen Melnikoff','email' => 'ivdq@ya.ru','password' => "$2y$10$lMFXoNhRcL85M3JbI2rekuyMlyGoo4uIZreBvLSwZiQh/8.p47oAm"]);
 
```




### Sail - help

```bash
./sail  php 
./sail  composer 
./sail  artisan art 
./sail  test
./sail  dusk 
./sail  dusk:fails 
./sail  tinker
./sail  node
./sail  npm 
./sail  npx 
./sail  yarn 
./sail  mysql 
./sail  psql 
./sail  shell bash 
./sail  root-shell
./sail  share 
```


### html
 *  don`t download file -> show inline ``` Content-Disposition: form-data ```
### html embedded.pdf
https://www.labnol.org/embed-pdf-200208
https://pdfjs.express/blog/how-embed-pdf-in-html-website#embed-pdf-in-html-with-pdfjs
https://documentcloud.adobe.com/view-sdk-demo/index.html#/view/LIGHT_BOX/Bodea%20Brochure.pdf


### TailWind
-- base example tailwind css
https://tailwindcss-forms.vercel.app/
https://tailwindcomponents.com/components/Forms

-- example good form
https://codepen.io/ramene/pen/vYEKrab

https://github.com/creativetimofficial/tailwind-starter-kit

### Laravel.routes
Структурируем маршруты в крупных проектах на Laravel - 
https://otus.ru/nest/post/841/

laravel route view with parameter
https://www.codegrepper.com/code-examples/php/laravel+route+view+with+parameter

### Laravel.streams.for.memory.reservation
https://dev.to/styxofdynamite/streaming-large-file-downloads-in-laravel-2nne
https://stackoverflow.com/questions/36778167/download-from-laravel-storage-without-loading-whole-file-in-memory


### Laravel.Forms
https://github.com/protonemedia/laravel-form-components


### laravel.examples.project
1. https://github.com/guillaumebriday/laravel-blog


### Laravel.Eloquent
1. https://darkghosthunter.medium.com/laravel-understanding-eloquent-relationships-with-drawings-50e6c332a7df

2. speed optimixation https://geekflare.com/laravel-optimization/

### Laravel custom user provider
1. custom user provider
https://gist.github.com/paulofreitas/08ea4f2f09102df8630b8a3c8d7a41bb

### смотрел
курс на русском - 
https://www.youtube.com/watch?v=i98TUvjQZyw




## PHP

 * New in php 8 -https://stitcher.io/blog/new-in-php-8
 * serialize closure https://www.amitmerchant.com/serialize-closures-php-package/
 * dynamic blades documents https://www.amitmerchant.com/dynamic-blade-components-in-laravel-8/
 * components https://www.twilio.com/blog/dont-repeat-yourself-html-laravel-7-blade-components-php



