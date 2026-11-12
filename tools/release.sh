#!/bin/bash
set -xe

if [ $# -eq 0 ]; then
  echo "Usage: $0 /path/to/atom-version-date-hash.tar.gz"
  exit 1
fi
FILENAME=$(basename $1)
VERSION="$(echo $FILENAME | sed 's/\.tar\.gz$//' | sed 's/^atom-//')"

echo "Releasing $VERSION"

gh release create $VERSION $1 \
  --title "$VERSION" \
  --notes "Release $VERSION" \
  --target main
