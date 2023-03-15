FROM nginx:alpine

COPY ./nginx.conf /etc/nginx
RUN rm -rf /etc/nginc/conf.d/default.conf
COPY ./default.conf /etc/nginc/conf.d/default.conf
