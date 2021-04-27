Первый этап
~~~~
docker-compose build
docker-compose up -d
~~~~

После запуска docker
~~~~
docker-compose run --rm workspace composer install

docker-compose run --rm workspace mkdir -m777 backend/web/assets
docker-compose run --rm workspace mkdir -m777 frontend/web/assets

docker-compose run --rm workspace php init
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


