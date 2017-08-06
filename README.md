# My-Insta

An Instagram-like, just for fun!

## Requirements:
- Docker 1.9
- Docker Compose 1.4

## Installation 

Create images for Docker
```console
chmod +x create-images.sh
./create-images.sh
```

Define permissions in folders & conf files
```console
chmod +x install.sh
./install.sh
```

Install application
```console
docker-compose run app install
```
## Launch the application

**Development**

By default, the application is launch in development environment.

**Production**

To launch the application in production environment, modify the variable APP_ENV in 'docker-compose.yml':
```console
services:
  app:
    environment:
      APP_ENV: prod
```

**Launching**

Run the cluster
```console
docker-compose up
```

In another terminal
```console
docker exec -ti app bash
```

## Development 

- Don't miss to add 127.0.0.1 dopsyng.local in /etc/hosts (Unix)
- Don't miss to add <VM ip> dopsyng.local in /etc/hosts (OSX) or in Windows/System32/drivers/etc/hosts (Win)
## Author:

**Tifenn Guillas**
- <http://tifenn-guillas.fr>
- <https://github.com/tifenn-guillas>

## Technologies

- Docker
- Back-end:
    - PHP7
    - Symfony3
    - Composer
    - PhpUnit
- Front-end:
    - Angular4
    - Webpack
    - Bootstrap3
- MySQL
