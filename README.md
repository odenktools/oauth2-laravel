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
composer install
```

```bash
cp .env.example .env
```

```bash
sudo chmod -R 777 storage/
sudo chmod -R 777 bootstrap/cache/
```

```
CHANGE YOUR DATABASE CONNECTION at .env file

CREATE DATABASE NAME laravel_oauth
```

```bash
php artisan migrate --seed
php artisan passport:keys
php artisan passport:client --password
php artisan passport:client --client
php artisan vendor:publish --provider="Optimus\Heimdal\Provider\LaravelServiceProvider"
composer dumpautoload
```

```bash
php artisan serve
```

```
Yey! Your Application run at http://localhost:8000
```

### TESTING OAUTH2

#### LOGIN

```bash
curl --location -X POST 'http://localhost:8000/api/login' -H 'Accept: application/json' -H 'Content-Type: application/x-www-form-urlencoded' -d 'client_id=1&email=odenktools@gmail.com&password=qwerty&scope=all'
```

#### ACCESS

```bash
curl --location -X GET 'http://localhost:8000/api/check-oauth-passwd' -H 'Accept: application/json' -H 'Authorization: Bearer YOUR_ACCESS_TOKEN_HERE'
```

**result**

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2JmZWY0YTFiZWNmNDZhMmYxMWE0N2E4YjU0MThmZjM4MDAwOTg5N2E5MDRjZDNhMTljMmIzZDdmMzQ3MTdiNzcwN2U5YmNmNmYzOTczNTEiLCJpYXQiOjE1ODYwNzYzNDAsIm5iZiI6MTU4NjA3NjM0MCwiZXhwIjoxNjE3NjEyMzQwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.X8rEa1FGnsAMbbbiAOd9HmjDRkuSlf1aJvbHUNn2zCUDnZf2KwiQ7jHPcYTz6ED-CWqFMmqfw5_qJ-4dxX6KExOhnn00LEK3WpdQjWo5rAR4ZCL074_1kvgYg8LC3mtPsnIwpqPmdqmOAr4SdxBo2lqbKxXvBOqUvOLGxtGy2sAz1UD2Mwvsqud4--nRce8YyU_dwnuXaUmHuxangKCiodMTC-JQOdjC4qlvOD0qh8RY2BF-44LXwhUpu3xDYL3_b5_UYAJv4fS4ybArVcGSfssKs-Lf8bzu5m4Jy4_gWDVYnXMhqJWwKN9CJjmF7OnoMzJz4nFjBOVqXhjdwHR_jWJ3X-zui7I1nAuhEqMUkU_Q8dmnmOM-QkjV-uF18gczX1-cc8sTAFQmQjy6O_Cne1c_OjD3hsqPIbAxaIA_93X4Rbber76ykvSeR1XOwcwSFECcAZd0PS0TquR4g7g1c5tccnpAF9mz1HX5X7P-hVokh7o9F1BlskjOHRDE-57oywWa8gYWs5lhzjyDlnJnOMLsvHHFVwK3K2PC0EBJpNlgE1qWS0fIg-jZdlEZpprcBwQJE4UlHmr6GFkjWqePFbnV8vjO_8U6lABWVYvAwGeh8mgGef3ooRanFzoE2SSm_Cf4cErBf7OT13N-PnT19P0IuoQl_EMXvm8AXCHW66E",
    "refresh_token": "def50200319a7c7b562ed3dc2f038eb6c6f50f276456356204208d5662076717f90aae122e46b5efbae31c567becbd39e3f260897ab9f7616a9204b30bbf4482f0de9ec40b71d983891d22c8a78ed9cc3b5b8ed2a199576b40cacdec2b5e4fbd5b45259aea75edf801e2fc4311b0f7413afbc4e4429097c705ceec9b7e19d5783d83d5d9f55f45af89e580a962662ac27cbeea7fbd28bb55a3bc6a96c9dc8a58341a2f1e3e77f20734a96fa8a2173f2439b69a75bde310f25ca4ec76fdb4dd0d5cfb6136d02d6ecba14c204f845329f6a70a76190c04bafae70422b53b5226f1cd4a110d7d04057d807731fd3930d48da1d783b411e504390c76c1625630c826f2e373838e420e405c5d637808a70565be31e98c6e2038fefed93dd5704d6e7db81c16dc7ae216a8de28a04ffefa43eb5a63bb00857ebbc87c34c5c894282047916e910bd0253f5c659b12ab736ea49f6e1cf6d3c266fbf3e104584e795d1854b9",
    "expires_in": 31536000
}
```

**example**

```bash
curl --location -X GET 'http://localhost:8000/api/check-oauth-passwd' -H 'Accept: application/json' -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYmYwNTkwYmNhNGE1M2Y4OTYxZDc4MTgzZTJkZjk0YmFkM2U3ZWY1OGI0Y2M2MWE4OWVlMGI4YWRiYzUxN2IyYzk4NjI0MTA1MmU3NDI0OTYiLCJpYXQiOjE1ODYwNzU4NjksIm5iZiI6MTU4NjA3NTg2OSwiZXhwIjoxNjE3NjExODY5LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.SyAmzuNB6fR8hgvRnXMl4CQ_GY0asHbqL6DrfuC6cByFCGVYJZOItS5Zl5LnszWTCgepmL7sK5-OsjQI1xhn7jD4TbFO5JsuAydDUfc3IU_0DHOxWZQxCNz840l8sgvLzpgPXOeYoFfaEQcft-qFzCx8yzm2Ol8WZDRXkuLYpJ31R9i9R_eM1dHYr1Vm0qoxLMYmqYSPzTIWPSGPgTrEU9KkveErCqWUIyxjdu_Tk-sJIux-J2XahwZfuGOWxcKzeGfmRoepL-U3SZCAusTESyox3It-aErJMbZCPIlxbl22rzgeA8roJVcFr5EG49gDuylCZtyckxpLiAru6uECRHEnxA3vxhwfXujljfV9thbYoWl7mj7j2RwGQu8jqo3Oki81ZtIPhucJ28d8uOsGqVCd6ZzU6FWVAz_Z9hk_IFf8UaMq6w0zMAT_WwZ8JYlWu18ADTLKfmtey05aGHG3G0bEC0OYycTcwNFyn5L6VgjMvsciwHlN1BL7GrmM77f4shluLQQzqodeF2bOf3JZ8-WXjS0SMr_NhkNXKc9gYwbn0QS0yzgSj8G1iWlNYhCXoFk8gmOk44uGTyEU-s3Q5Wg8cjoNDqOWJmPutFcXfEGhXUHsjPplh7EzbnwIc2qsVgf2zh-vYnzYnV4PMnqwF482lD7VNgH8EybN9cNQtKQ'
```

**result**

```json
{
    "id": 1,
    "company_id": 1,
    "name": "odenktools",
    "email": "odenktools@gmail.com",
    "email_verified_at": "2020-04-05 06:21:54",
    "created_at": "2020-04-05 06:21:54",
    "updated_at": "2020-04-05 06:21:54"
}
```

#### CLEANUP TOKEN

```sql
TRUNCATE TABLE oauth_refresh_tokens;
TRUNCATE TABLE oauth_access_tokens;
```

#### OAUTH2 AUTHORIZATION GRANTS

- [Client Credentials](https://tools.ietf.org/html/rfc6749#section-1.3.4)

- [Resource Owner Password Credentials](https://tools.ietf.org/html/rfc6749#section-1.3.3)

## License

The Laravel Oauth2 is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
