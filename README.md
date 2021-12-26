
  

![enter image description here](https://github.com/rlmyandaa/LaraKKN_8/blob/main/public/images/ico.jpeg)

#  LARA KKN 8

**Laravel KKN management web apps based on Laravel 8 and using Jeremy Kenedy Laravel-Auth as User and Role Management.**

  
  

#  Short Features

###  Student Side :

1. Propose Proker.

2. Daily Report Submit.

3. Final Report Management.

  

###  Dosen Side :

1. Assign Group and Group Token.

2. Reject / Acc Program Kerja.

3. Monitor Daily Report.

4. Final Report Management.

  
  

#  Components Used

1. Jeremy Kennedy Laravel-Auth : [https://github.com/jeremykenedy/laravel-auth](https://github.com/jeremykenedy/laravel-auth)

2. nWidart Laravel Modules : [https://github.com/nWidart/laravel-modules](https://github.com/nWidart/laravel-modules)

3. Jeroen Noten Laravel-AdminLTE Dashboard : [https://github.com/jeroennoten/Laravel-AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE)

  
  
  

#  Instalation

####  Laravel-Auth Step

1. Run `git clone https://github.com/rlmyandaa/LaraKKN_8.git`

2. Create a new database for the app

3. From the projects root run `cp .env.example .env`

4. Configure your `.env` file

5. Run `composer update` from the projects root folder

6. From the projects root folder run:

```

php artisan vendor:publish --tag=laravelroles &&
php artisan vendor:publish --tag=laravel2step

php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

```

7. From the projects root folder run `sudo chmod -R 755 ../LaraKKN_8`

8. From the projects root folder run `php artisan key:generate`

9. From the projects root folder run `composer dump-autoload`

10. From the projects root folder run `php artisan migrate --seed`

12. From the projects root folder run `npm install`

13. From the projects root folder run `npm run dev` or `npm run production`

  
  

#  Live Demo

**Demo URL : http://larakkn.hpaa.space/**

--

**Demo Account :**

There are 5 demo accound, 2 Dosen Accounts and 3 Student Accounts.
To login just click on desired account in login page.

  
  
  
