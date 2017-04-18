#!/bin/sh
rm -rf /var/www/dayinji/static/*
cp -r ./static/* /var/www/dayinji/static/
rm -rf ./static
cp -r ./plugin/* /var/www/dayinji/library/smarty/plugins
rm -rf ./plugin
