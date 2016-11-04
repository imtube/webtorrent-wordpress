#!/bin/sh
set -e

# NOTE: This script assumes that PWD is the webtorrent-wordpress folder. Do not run
# this script from another folder, i.e. ./code/webtorrent-wordpress/build.sh
# Always run it like this: ./build.sh

rm -rf /tmp/webtorrent-wordpress
rm -f /tmp/webtorrent-wordpress.zip
rm -f webtorrent-wordpress.zip

cp -R . /tmp/webtorrent-wordpress
rm -rf /tmp/webtorrent-wordpress/.git /tmp/webtorrent-wordpress/.DS_Store /tmp/webtorrent-wordpress/.gitignore /tmp/webtorrent-wordpress/build.sh

(cd /tmp && exec zip -r -y webtorrent-wordpress.zip webtorrent-wordpress)

echo $(pwd)
cp -R /tmp/webtorrent-wordpress.zip .
