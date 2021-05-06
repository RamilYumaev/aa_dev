Первый этап
~~~~
docker-compose build
docker-compose up -d
~~~~

После запуска docker
~~~~
autoconf.sh install
autoconf.sh update
autoconf.sh migrate
~~~~

~~~~
docker-compose run --rm workspace mkdir -m777 entrant/web/assets
docker-compose run --rm workspace mkdir -m777 operator/web/assets
~~~~
URLs localhost

FRONTEND
http://localhost:8001

BACKEMD
http://localhost:8002

API
http://localhost:8003/

ENTRANT 
http://localhost:8004/

OPERATOR
http://localhost:8005/

PHPMYADMIN
http://localhost:8181/

u:root p:root
~~~~




