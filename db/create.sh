#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE sanlucar_test;"
    psql -U postgres -c "CREATE USER sanlucar PASSWORD 'sanlucar' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists sanlucar
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists sanlucar_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists sanlucar
    sudo -u postgres psql -c "CREATE USER sanlucar PASSWORD 'sanlucar' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O sanlucar sanlucar
    sudo -u postgres createdb -O sanlucar sanlucar_test
    LINE="localhost:5432:*:sanlucar:sanlucar"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi
