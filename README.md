
![enter image description here](https://raw.githubusercontent.com/rlmyandaa/LaraKKN_8/master/public/images/ico.jpeg)
# LARA KKN
**Laravel KKN management web apps based on Jeremy Kenedy Laravel Auth 7.**


# Short Features
### Student Side :
1. Propose Proker.
2. Daily Report Submit.
3. Final Report Management.

### Dosen Side :
1. Assign Group and Group Token.
2. Reject / Acc Proker.
3. Monitor Daily Report.
4. Final Report Management.


# Components Used
1. Jeremy Kennedy Laravel-Auth : [https://github.com/jeremykenedy/laravel-auth](https://github.com/jeremykenedy/laravel-auth)
2. nWidart Laravel Modules : [https://github.com/nWidart/laravel-modules](https://github.com/nWidart/laravel-modules)
3. Jeroen Noten Laravel-AdminLTE Dashboard : [https://github.com/jeroennoten/Laravel-AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE)



# Instalation
#### Laravel-Auth Step
1. Run `git clone https://github.com/jeremykenedy/laravel-auth.git laravel-auth`
2. Create a new Database in mysql
3. From the projects root run `cp .env.example .env`
4. Configure your `.env` file
5. Run `composer update` from the projects root folder
6. From the projects root folder run:
```
php artisan vendor:publish --tag=laravelroles &&
php artisan vendor:publish --tag=laravel2step
```
7. From the projects root folder run `sudo chmod -R 755 ../lara-kkn`
8. From the projects root folder run `php artisan key:generate`
9. From the projects root folder, open db_table folder and import larakkn.sql to mysql database
10. From the projects root folder run `composer dump-autoload`
11. From the projects root folder run `php artisan db:seed`
12. From the projects root folder run `npm install`
13. From the projects root folder run `npm run dev` or `npm run production`

### nWidart Laravel Modules Step
1. From project root folder run `php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"`


# Live Demo
**Demo URL : http://larakkn.l0wpass.site/**
--
**Demo Account :**
|Role|Email|Password|
|:------------|:------------|:------------|
|Student|student_demo@larakkn.com|password|
|Dosen|dosen_demo@larakkn.com|password|
|Admin|admin@admin.com|password|



**For Operational Purpose, registering student user could be done directly from Register menu. But for registering Dosen account recommended to be done from Admin user dashboard via Create New User menu using Admin. Or you could Register directly from Normal Register Link, but you need to set up the mailtrap or any valid mail server.**


