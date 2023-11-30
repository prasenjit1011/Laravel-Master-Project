-: Todo Project :-

Project Important Command List : 

composer create-project laravel/laravel todo 

composer require laravel/ui:* 

php artisan ui react --auth 

php artisan migrate 

npm install && npm run dev


php artisan migrate:rollback --step=1

php artisan make:migration add_status_to_users_table --table=users 

php artisan make:migration create_todo_table 

php artisan event:list<br />
php artisan make:event TodoAlert<br />
php artisan make:listener SendTodoAlert --event=TodoAlert<br />
