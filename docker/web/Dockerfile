FROM node:24-bookworm

WORKDIR /app

COPY apps/web/package*.json ./

RUN npm install

COPY docker/web/start-web.sh /usr/local/bin/start-web

RUN chmod +x /usr/local/bin/start-web

CMD ["start-web"]
