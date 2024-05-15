## Custom Jalali Date Picker

### Instalation
- Clone The Project
- Run sudo docker-compose build --no-cache
- sudo docker-compose up
- Open Browser and hit localhost:8000/login
- the Test username and password already presented in frontend

if project did not run do below commands

- sudo docker exec --user=root -it my-laravel-app sh
- and run chmod -R 777 /var/www/storage
- then run php artisan migrate --seed
- then exit the container and run sudo docker exec --user=root -it my-laravel-node sh
- then run npm run build

## also there's a bug which caused by jalali-moment js library that shows first day of month in Wrong day of the week

## my focus was on making custom date picker that's why the backend is a bit messy

## also for better understanding of my backend skills you can check out this repo [asan-card-task](https://github.com/matt-1996/asan-card-task)

![Jalali Date Picker](https://github.com/matt-1996/vue-custom-jalali-datePicker/blob/main/public/images/1.png?raw=true)

![Jalali Date Picker](https://github.com/matt-1996/vue-custom-jalali-datePicker/blob/main/public/images/2.png?raw=true)

![Jalali Date Picker](https://github.com/matt-1996/vue-custom-jalali-datePicker/blob/main/public/images/3.png?raw=true)

![Jalali Date Picker](https://github.com/matt-1996/vue-custom-jalali-datePicker/blob/main/public/images/4.png?raw=true)

if Docker did not work contact me through [Email](mailto:matinnasirlahijani@gmail.com) 

Email Address: [matinnasirlahijani@gmail.com](mailto:matinnasirlahijani@gmail.com)
