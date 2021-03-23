FROM ubuntu
MAINTAINER 0xdeciverAngel
WORKDIR /project
ADD . .
RUN ls
RUN ["bash","setup.sh"]
# VOLUME vol
EXPOSE 8000
CMD ./startup.sh