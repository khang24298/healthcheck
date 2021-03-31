#!/bin/bash
php ~/Sites/healthcheck/artisan --env=production  --sleep=123 --tries=123 --queue=123 --timeout=123 queue:listen