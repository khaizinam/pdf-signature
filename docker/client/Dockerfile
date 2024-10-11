# Image
FROM node:18-alpine

# Set up work directory
WORKDIR /var/www/client

# copy the app, note .dockerignore
COPY ../../client /var/www/client

RUN npm install
RUN npm run build

EXPOSE 3000

ENV NUXT_HOST=0.0.0.0
ENV NUXT_PORT=3000

CMD [ "npm", "start" ]
