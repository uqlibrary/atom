#!/bin/bash

set -xe
apk add --no-cache grep git rsync

mkdir /builder
rsync -a /atom/src/ /builder/
chown -R root:root /builder
cd /builder

#QUBIT_CHANNEL_EXISTS=$(pear channel-info pear.qubit-toolkit.org 2>/dev/null || echo "not found")
#if [ "$QUBIT_CHANNEL_EXISTS" = "not found" ]; then
pear channel-discover pear.qubit-toolkit.org
#fi

./vendor/composer/phing/phing/composer/bin/phing build -verbose

rsync -a /builder/build/ /build
chown -R $OUT_USER:$OUT_GROUP /build