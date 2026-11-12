#!/bin/bash
# php deps
echo "Checking composer deps..."
composer update
# npm deps
echo "Checking npm deps..."
npm audit fix --package-lock-only


#for i in composer.json composer.lock package.json package-lock.json; do
#  chown $CHOWN_USER_ID:$CHOWN_GROUP_ID /atom/src/$i
#done
