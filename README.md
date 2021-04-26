Первый этап
~~~~
1 docker-compose build
2 docker-compose up -d
~~~~

После запуска docker
~~~~
docker-compose run --rm workspace composer install
docker-compose run --rm workspace php init
docker-compose run --rm yii migrate
~~~~

URLs localhost
~~~~
FRONTEND
http://localhost:8001

BACKEMD
http://localhost:8002

API
http://localhost:8003/

PHPMYADMIN
http://localhost:8181/

u:root p:root
~~~~


