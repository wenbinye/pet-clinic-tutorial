FROM busybox:1.29

COPY config resources routes src vendor console composer.json composer.lock /app
