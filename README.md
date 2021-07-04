# Magebit task
## VueJS + PHP + MySQL

For this demo I was using [WAMP](https://www.wampserver.com/en/) server, whole project was inside of ```./www/``` directory.  
After cloning:

```shell
cd ./frontend/
```
Create ```.env``` file inside of ```./frontend/``` directory with specified ```VUE_APP_SERVER_URL``` server endpoint (see ```.env.example``` file).
```shell
npm i
npm run serve
```

In another terminal
```shell
cd ./server/
```
Create database (default: ```web_dev_email```) and configure ```config.php``` file with its' credentials.
```shell
cd ./database/
```

Create main table
```shell
php ./schema.php -up
```

Project is ready.

<hr/>  

If you need to drop main table
```shell
php ./schema.php -down
```
If you need test cases for table
```shell
php ./seed.php
```

<hr/>

How to run:
* http://localhost:8080 - Email subscription page
* http://localhost:8080/table - Table with emails

Table controls:
* _Search:_ field used for searching e-mails; applies automatically
* Sorting is permormed by pressing on the table's header
* Checkboxes are used to specify e-mail record(s) for export; export by pressing appearing button ```Export e-mails```
* _Per Page:_ field used for pagination; use ```OK``` to apply
* Use ```<``` ```>``` buttons to navigate between pages
* Sort by e-mail domain by pressing on one of the available emails on the right; clear selection by pressing appearing button ```Clear```
