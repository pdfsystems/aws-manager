FROM ghcr.io/rpungello/laravel-frankenphp:php8.5-trixie

ARG VERSION=1.0.0
ENV APP_VERSION=${VERSION}
ENV NIGHTWATCH_DEPLOY=${VERSION}
ENV NIGHTWATCH_INGEST_URI=nightwatch:2407
ENV USER=aws
ENV SERVER_NAME=:8000

ARG FLUX_USERNAME

COPY . /app
RUN --mount=type=secret,id=FLUX_LICENSE_KEY \
    composer config "http-basic.composer.fluxui.dev" "${FLUX_USERNAME}" "$(cat /run/secrets/FLUX_LICENSE_KEY)" \
 && composer install && npm install && npm run build && npm cache clean --force \
 && rm -f /app/auth.json \
 && useradd -m ${USER} \
 && chown -R ${USER}:${USER} /app \
 && chown -R ${USER}:${USER} /data \
 && chown -R ${USER}:${USER} /config \
 && chown -R ${USER}:${USER} /usr/local/etc/php/conf.d

USER ${USER}

HEALTHCHECK CMD ["php", "artisan", "health:check", "--fail-command-on-failing-check"]
