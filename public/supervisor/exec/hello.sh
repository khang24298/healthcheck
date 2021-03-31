#!/bin/bash
php ~/Sites/healthcheck/artisan --env=production  --sleep=10 --tries=1 --queue=default --timeout=10 queue:listen