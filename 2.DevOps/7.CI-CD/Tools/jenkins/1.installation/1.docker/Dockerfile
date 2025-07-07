

# docker run --name jenkins-docker --rm --detach --privileged --network jenkins --network-alias docker --env DOCKER_TLS_CERTDIR=/certs --volume jenkins-docker-certs:/certs/client --volume jenkins-data:/var/jenkins_home --publish 2376:2376 docker:dind

# Dockerfile
FROM jenkins/jenkins:2.504.3-jdk21

USER root

RUN apt-get update && apt-get install -y lsb-release

# Add Docker repo and key
RUN curl -fsSLo /usr/share/keyrings/docker-archive-keyring.asc https://download.docker.com/linux/debian/gpg

RUN echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.asc] \
https://download.docker.com/linux/debian $(lsb_release -cs) stable" > /etc/apt/sources.list.d/docker.list

# Install Docker CLI
RUN apt-get update && apt-get install -y docker-ce-cli

USER jenkins

# Add plugins (Blue Ocean + Docker support)
RUN jenkins-plugin-cli --plugins "blueocean docker-workflow json-path-api"

# docker build -t myjenkins-blueocean:2.504.3-1 .
# docker run --name jenkins-blueocean --restart=on-failure --detach --network jenkins --env DOCKER_HOST=tcp://docker:2376 --env DOCKER_CERT_PATH=/certs/client --env DOCKER_TLS_VERIFY=1 --volume jenkins-data:/var/jenkins_home --volume jenkins-docker-certs:/certs/client:ro --publish 8080:8080 --publish 50000:50000 myjenkins-blueocean:2.504.3-1
# http://localhost:8080
# ngrok http 8080
# docker exec jenkins-blueocean cat /var/jenkins_home/secrets/initialAdminPassword

