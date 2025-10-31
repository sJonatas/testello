# Testello

## To build the env
First, start your docker machine and build the component by running the command below:

```shell
./vendor/bin/sail up -d
```
This will automatically install all dependencies, run the migrations and the seeders.
After the image is built, the application will be served on the link: `http://localhost`

Then, all you need to do is start the queue with the command below, and the app is ready to be used:
```shell
./vendor/bin/sail artisan queue:start
```

If you ever have to run the command individually:

```shell
# run migrations
./vendor/bin/sail artisan migrate

# seed the clients table
./vendor/bin/sail artisan seed --class=ClientSeeder

# build assets
./vendor/bin/sail npm run build

# run tests
./vendor/bin/sail test 
```
