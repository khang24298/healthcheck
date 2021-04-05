#!/bin/sh
php /Users/mac/Sites/healthcheck/artisan --queue=default --delay=3 queue:listen 