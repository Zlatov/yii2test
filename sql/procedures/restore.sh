#!/bin/bash
. ../success.sh
echo "accesses included";
mysql --database="$database" --user="$user" --password="$password" < ./procedures.sql;
echo "procedures restored";
bash