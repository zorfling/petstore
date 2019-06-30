# petstore

# Usage

First, clone this repository:

```bash
$ git clone https://github.com/zorfling/petstore.git
```

Start:

```bash
$ docker-compose up -d
```

Install dependencies:

```bash
$ docker-compose exec php composer install
```

Run migrations and load fixtures:

```bash
$ docker-compose exec php bin/console doctrine:migration:migrate
$ docker-compose exec php bin/console doctrine:fixtures:load
```

Add hostname in hosts file:

```
127.0.0.1 symfony.localhost
```

# Endpoints

## GET

- http://symfony.localhost/pet
- http://symfony.localhost/pet/1
- http://symfony.localhost/pet/findByStatus?status=available

## POST

- http://symfony.localhost/pet

```json
{
  "name": "doggie",
  "category": 1,
  "status": 1
}
```

---

Based on https://github.com/eko/docker-symfony implementing https://petstore.swagger.io/#/pet
