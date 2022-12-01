# Egal Tesk Task

Установка проекта

    git clone https://github.com/MrRouOne/EgalTestTask

Установка зависимостей

    Создайте файл .env и заполните его данными из файла .env.example

    CMD:
    copy .env.example .env

    Для ОС Linux нужно изменить 
    COMPOSE_FILE=docker-compose.yml;deploy/docker-compose.yml на 
    COMPOSE_FILE=docker-compose.yml:deploy/docker-compose.yml

Установка пакетов

    CMD:
    cd project && composer update --ignore-platform-reqs && cd ..

Запуск проекта

    docker-compose up -d --build

Вспомогательные команды

    Перезапуск контейнера

    docker-compose restart project


    Запуск миграций с сидерами   

    docker-compose exec project php artisan migrate --seed --force
    