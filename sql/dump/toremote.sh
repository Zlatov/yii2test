#!/bin/bash
scp dump.sql zlatov:~/zlatov.net/yii/sql/dump/
ssh zlatov << EOF
~/zlatov.net/yii/sql/dump/restore.sh
EOF
bash
