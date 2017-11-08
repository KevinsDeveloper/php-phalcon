#!/bin/bash

#path=/vagrant_data/mendao/apps/task/
path=/home/wwwroot/mendao/apps/task
cd $path

for i in {1..6}
do
    count=`ps -ef | grep user.sh | grep -v "grep" | wc -l`
    if [[ $count -gt 0 ]]; then
        php run.php main user >> /tmp/user.log &
    fi
    sleep 10
done