FROM ubuntu
MAINTAINER 0xdeciverAngel
WORKDIR /project
ADD . /project
RUN ./setup.sh
# VOLUME vol
EXPOSE 8000
CMD ./startup.sh