[< Назад к оглавлению](../README.md)

___

### Настройка окружения
Проект построен на базе файла конфигурации `docker-compose.yml`
Параметры, которые для исключения конфликтов с Вашей системой лучше проверить до запуска проекта:
 - docker-compose.yml
   ```yml
   mysql:
     
     ...
     
     ports:
         # здесь происходит проброс порта БД наружу.
         # "3396" можно заменить на любой свободный,
         # если этот на Вашей машине занят
       - 3396:3306
 
   ```

### Запуск проекта
1. Проект собирается и запускается командой
   ```bash
   docker compose up -d
   ```
2. После этого нужно зайти в контейнер командой
   ```bash
   docker compose exec php-fpm bash
   ```
3. Убедиться, что docker вашей ОС не ругнулся и действительно зашёл внутрь контейнера
4. Выполнить команду
   ```bash
   composer install
   ```
   И дождаться завершения работы команды, попутно отвечая на вопросы консоли