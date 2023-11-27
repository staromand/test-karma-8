cat ./docker/data/mysql/dataset.sql | docker exec -i $(docker compose ps | grep mysql | awk '{print $1}') /usr/bin/mysql -u test_karma8 --password=test_karma8 test_karma8
