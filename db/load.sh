#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U sanlucar -d sanlucar < $BASE_DIR/sanlucar.sql
fi
psql -h localhost -U sanlucar -d sanlucar_test < $BASE_DIR/sanlucar.sql
