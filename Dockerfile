FROM alpine:3.13

ARG BUILD_DATE=""
ARG VCS_REF=""
ARG VERSION=""

LABEL maintainer="https://github.com/localgod/karla.git" \
      org.label-schema.schema-version="1.0" \
      org.label-schema.vendor="Localgod" \
      org.label-schema.name="localgod_build" \
      org.label-schema.license="MIT" \
      org.label-schema.description="ImageMagick wrapper with method chaining, " \
      org.label-schema.vcs-url="https://github.com/localgod/karla.git" \
      org.label-schema.vcs-ref=${VCS_REF} \
      org.label-schema.build-date=${BUILD_DATE} \
      org.label-schema.version=${VERSION} \
      org.label-schema.url="http://localgod.github.io/karla/" \
      org.label-schema.usage="https://raw.githubusercontent.com/localgod/karla/master/README.md"

ARG bash_version=5.1.0-r0
ARG php8_version=8.0.6-r0
ARG make_version=4.3-r0
ARG jq_version=1.6-r1
ARG git_version=2.30.2-r0
ARG imagemagick_version=7.0.11.13-r0
ARG composer_version=2.0.13-r0
ARG php8_pecl_xdebug=3.0.4-r0
ARG pcre_version=8.44-r0
ARG php_major_version=php8
ARG php_version=8.0.6-r0

RUN for value in phar iconv openssl curl mbstring tokenizer xmlwriter simplexml dom xml fileinfo; do apk --update --no-cache add ${php_major_version}-${value}=${php_version}; done

RUN apk --update --no-cache add \
    bash=${bash_version} \
    composer=${composer_version} \
    git=${git_version} \
    imagemagick=${imagemagick_version} \
    jq=${jq_version} \
    make=${make_version} \
    pcre=${pcre_version} \
    php8=${php8_version} \
    php8-pecl-xdebug=${php8_pecl_xdebug}

RUN ln -s -f /usr/bin/php8 /usr/bin/php && echo zend_extension=xdebug.so > /etc/php8/conf.d/50_xdebug.ini && \
    echo xdebug.mode=coverage >> /etc/php8/conf.d/50_xdebug.ini

