FROM node:9.11.1-alpine

MAINTAINER Vinicius Guedes <viniciusgued@gmail.com>

RUN mkdir -p /usr/mangone
WORKDIR /usr/mangone

# Prepares for running application
RUN npm install -g nodemon \
    && npm install

EXPOSE 3000
CMD ["npm", "run", "dev"]