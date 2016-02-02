#!/bin/bash
echo "Reading config...."
source ./success.sh
. ./success.sh
echo "Config for the databasename: $database"
echo "Execute mysql..."
mysql -D $database -u $user -p$password < ./procedures.sql
