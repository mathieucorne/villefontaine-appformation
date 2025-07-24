FROM php:8.5-rc-alpine3.22

RUN apk update && apk add --no-cache \
    zsh \
    bash \
    git \
    unzip \
    curl \
    ca-certificates \
    php-cli

ARG USERNAME=devuser
ARG USER_UID=1000
ARG USER_GID=${USER_UID}

RUN addgroup -g ${USER_GID} ${USERNAME} \
    && adduser -D -u ${USER_UID} -G ${USERNAME} -s /bin/zsh ${USERNAME}

USER ${USERNAME}
WORKDIR /home/${USERNAME}/app

ENV PATH="/home/${USERNAME}/.local/bin:/home/${USERNAME}/.symfony/bin:${PATH}"

RUN mkdir -p /home/${USERNAME}/.local/bin \
    curl -sS https://getcomposer.org/installer | php -- --install-dir="/home/${USERNAME}/.local/bin" --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash

CMD ["sleep", "infinity"]