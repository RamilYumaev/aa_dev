#!/bin/bash

    do_install() {
       docker-compose run --rm workspace composer install
       docker-compose run --rm workspace mkdir -m777 backend/web/assets
       docker-compose run --rm workspace mkdir -m777 frontend/web/assets
       docker-compose run --rm workspace php init
    }

    do_update() {
        docker-compose run --rm workspace composer update
        docker-compose run --rm workspace php yii migrate
    }

    do_migrate() {
     docker-compose run --rm workspace php yii migrate
    }
case "$1" in
    install)
        do_install
        ;;
      migrate)
        do_migrate
        ;;
    update)
        do_update
        ;;
    *)
    echo "Usage: docker.sh [exec|mysql-backup|mysql-restore|mysql-drop-table|mysql-truncate-database|tests|install|update|g:cest|g:test]"
    ;;

esac