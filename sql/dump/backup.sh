#!/bin/bash
source ../success.sh
echo accesses included;
mysqldump --user="$user" --password="$password" $database > ./dump.sql;
echo backup $database successful;
bash