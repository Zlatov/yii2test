#!/bin/bash
echo "Reading file success.sh..."
. ./success.sh
echo "Config for the databasename: $database"
echo "Execute mysql..."
mysql --database="$database" --user="$user" --password="$password" < ./procedures.sql