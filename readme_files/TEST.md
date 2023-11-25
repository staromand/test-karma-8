[< Назад к оглавлению](../README.md)

___

## Изменения в БД
Чтобы проверить изменение БД от исходного состояния к состоянию ожидающемуся, нужно будет запустить либо по очереди, либо сразу обе миграции.
После запуска первой можно будет увидеть изначальное состояние БД, а после запуска второй – то, к которому я пришёл

1. Перед запуском миграций нужно сначала войти в контейнер php-fpm
   ```bash
   docker compose exec php-fpm bash
   ```
2. Затем выполнить команду:
   - Для запуска только первой миграции:
     ```bash
     bin/console doctrine:migrations:migrate "DoctrineMigrations\Version20231125191916" --no-interaction
     ```
   - Для запуска сразу всех миграций до последней версии:
     ```bash
     bin/console doctrine:migrations:migrate --no-interaction
     ```