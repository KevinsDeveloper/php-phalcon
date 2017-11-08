#!/bin/bash

DATE=`date +%Y%m%d%H%M`
DATABASE=mendao
DB_USER=mendao
DB_PASS="Md*2017a98qQ"
BACKUP=/home/wwwback

#backup command
/usr/bin/mysqldump -u$DB_USER -p$DB_PASS -h 127.0.0.1 -R --opt $DATABASE |gzip > ${BACKUP}\/${DATABASE}_${DATE}.sql.gz

#just backup the latest 5 days
find ${BACKUP} -name "${DATABASE}_*.sql.gz" -type f -mtime +30 -exec rm {} \; > /dev/null 2>&1