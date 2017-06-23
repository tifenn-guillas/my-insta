# My-Insta

An Instagram-like, just for fun!

## Requirements:
- Docker 1.9
- Docker Compose 1.4

## How to install 

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

Install vendor
```console
docker-compose run php7 install
```

Install node_modules
```console
docker-compose run angular install
```

Run the cluster
```console
docker-compose up
```

It's done! You can access to the application through this url: http://localhost:4200/

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
