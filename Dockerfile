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
ARG php8_version=8.0.2-r0
ARG make_version=4.3-r0
ARG jq_version=1.6-r1
ARG git_version=2.30.2-r0
ARG imagemagick_version=7.0.10.57-r0
ARG composer_version=2.0.13-r0
ARG php8_phar_version=8.0.2-r0
ARG php8_iconv_version=8.0.2-r0
ARG php8_openssl_version=8.0.2-r0
ARG php8_curl_version=8.0.2-r0
arg php8_mbstring_version=8.0.2-r0
ARG php8_tokenizer_version=8.0.2-r0
arg php8_xmlwriter_version=8.0.2-r0
ARG php8_simplexml_version=8.0.2-r0
ARG php8_dom_version=8.0.2-r0
ARG php8_xml_version=8.0.2-r0

RUN apk --update --no-cache add \
    bash=${bash_version} \
    php8=${php8_version} \
    jq=${jq_version} \
    git=${git_version} \
    imagemagick=${imagemagick_version} \
    composer=${composer_version} \
    php8-phar=${php8_phar_version} \
    php8-iconv=${php8_iconv_version} \
    php8-openssl=${php8_openssl_version} \
    php8-curl=${php8_curl_version} \
    php8-mbstring=${php8_mbstring_version} \
    php8-tokenizer=${php8_tokenizer_version} \
    php8-xmlwriter=${php8_xmlwriter_version} \
    php8-simplexml=${php8_simplexml_version} \
    php8-dom=${php8_dom_version} \
    php8-xml=${php8_xml_version} \
    make=${make_version} && ln -s -f /usr/bin/php8 /usr/bin/php
