## About Laravel Oauth2

Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

## Learning Oauth2

#### INSTALL

```
cd /var/www/
git clone https://github.com/odenktools/oauth2-laravel.git
cd oauth2-laravel
git submodule update --init --recursive
```

```bash
cp .env.example .env
```

```
CHANGE YOUR DATABASE CONNECTION at .env file

CREATE DATABASE NAME laravel_oauth
```

```bash
php artisan migrate --seed
php artisan passport:client --password
php artisan passport:client --client
php artisan vendor:publish --provider="Optimus\Heimdal\Provider\LaravelServiceProvider"
```

```bash
php artisan serve
```

```
Yey! Your Application run at http://localhost:8000
```


```sql
TRUNCATE TABLE oauth_refresh_tokens;
TRUNCATE TABLE oauth_access_tokens;
```

#### OAUTH2 AUTHORIZATION GRANTS

- [Client Credentials](https://tools.ietf.org/html/rfc6749#section-1.3.4)

- [Resource Owner Password Credentials](https://tools.ietf.org/html/rfc6749#section-1.3.3)

## License

The Laravel Oauth2 is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
