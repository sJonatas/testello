# Testello

## To build the env
Before anything else, run command bellow to use a docker container to install the needed PHP dependencies for the project
(ensure the folder have enough permissions set):
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
With the dependencies installed, we can start the docker machine and build
the container by running the command below:

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
