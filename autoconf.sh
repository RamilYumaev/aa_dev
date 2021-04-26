#!/bin/bash

do_install() {
   docker-compose exec frontend composer install
   docker-compose exec frontend php yii migrate/up
}

do_update() {
    docker-compose exec frontend composer update
    docker-compose exec frontend php yii migrate/up
    }
case "$1" in
    install)
        do_install
        ;;
    update)
        do_update
        ;;
    *)
    echo "Usage: docker.sh [exec|mysql-backup|mysql-restore|mysql-drop-table|mysql-truncate-database|tests|install|update|g:cest|g:test]"
    ;;

esac