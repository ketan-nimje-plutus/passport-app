Laravel project passport api setup.
referance link:-
https://laravel.com/docs/8.x/passport
https://blog.logrocket.com/laravel-passport-a-tutorial-and-example-build/

For Laravel passport configuratio follow below step:-

step 1: composer require laravel/passport
step 2: php artisan migrate
step 3: php artisan passport:install

step 4: After running the passport:install command, add the Laravel\Passport\HasApiTokens trait to your App\Models\User model
		use Laravel\Passport\HasApiTokens; add this namespace
		use HasApiTokens, HasFactory, Notifiable;
step 5: Next you should call the Passport::routes method within the boot method of your App\Providers\AuthServiceProvider. 
		public function boot()
		{
			$this->registerPolicies();

			if (! $this->app->routesAreCached()) {
				Passport::routes();
			}
		}

step 6: Finally, in your application's config/auth.php configuration file, you should set the driver option of the api authentication guard to passport. 
		'guards' => [
			'web' => [
				'driver' => 'session',
				'provider' => 'users',
			],
		 
			'api' => [
				'driver' => 'passport',
				'provider' => 'users',
			],
		],
		
For Factory you need to create factory using below command
		
step 1: php artisan make:factory PostFactory



"# passport-app" 
