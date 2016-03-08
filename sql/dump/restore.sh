#!/bin/bash
source ../success.sh
echo accesses included;
mysql --database="$database" --user="$user" --password="$password" < ./dump.sql
echo restored $database successful;
bash