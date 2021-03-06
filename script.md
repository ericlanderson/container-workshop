Script
======

Can be used to copy-paste from here to the Terminal/Powershell instead of all of that typing.

This document lives at https://github.com/ericlanderson/container-workshop.

Preliminaries
-------------

	$ cd container-workshop

	$ git pull

	$ cd sample-php

Getting started: Docker
--------------------------
First steps with Docker.

	$ docker version

	$ docker run hello-world

Run a container based on the Ubuntu image and start an interactive shell with bash so we can run commands inside the container:

	$ docker run -it ubuntu bash

Verify the version of the container, run top and install ping:

	# cat /etc/os-release

	# top

	# apt update
	
	# apt -y install iputils-ping

	# ping 8.8.8.8

	# exit
	
Now run a container based on CentOS and compare with Ubuntu:
	
	$ docker run centos cat /etc/os-release
	
	$ docker run centos uname -r
	
	$ docker run ubuntu uname -r
	
Run a web server
----------------
Run a web server using the official Apache image:
	
	$ docker run --detach --name web-server httpd
	
	$ docker ps
	
	$ docker images
	
Let's poke around inside the container and find out what distro the Apache image is based on:

	$ docker exec -it web-server bash 
	# cat /etc/os-release 
	# top 
	# apt update
	
	# apt -y install procps 
	# top
	
	# exit
	
Kill off the web-server container and remove the container so we can use the name again:
	
	$ docker kill web-server
	
	$ docker ps -a
	
	$ docker rm webserver
	
Run the webserver again but map port 80 from the container to port 8080 on the host:

	$ docker run -d --rm --name web-server --publish 8080:80 httpd
	
	Browser: http://localhost:8080
	
	$ docker kill web-server
	
Adding content
--------------

Let's add some content and map the ./php directory into the container where Apache expects the content (/usr/local/apache/htdocs):

	$ docker run -d --rm --name web-server --volume ${PWD}/php:/usr/local/apache2/htdocs -p 8080:80 httpd
	
	$ docker logs web-server
	
	$ docker kill web-server

Change the image we are using to one that supports our PHP content but note that the PHP image expects the content in a different location (/var/www/html):

	$ docker run -d --rm --name web-server -v ${PWD}/php:/var/www/html -p 8080:80 php:7.0-apache
	
	Browser: http://localhost:8080/info.php
	
	$ ls -l php
	
Add a file inside the container using the touch command and see that it exists on the host:

	$ docker exec -it web-server bash
	
	# touch testfile.txt
	
	# ls -l
	
	# exit
	
	$ ls -l php
	
Let's make it easier
--------------------
Use docker-compose command to run our container.

	$ docker-compose up -d
	
	$ docker-compose logs

We can exec into the container but we will use the "service" defined in the docker-compose.yml file instead of the container name:
	
	$ docker-compose exec web ls -l
	
	$ docker-compose kill
	
	$ docker-compose rm
	
Let's build an image
--------------------

	$ docker build -t my-php-app:7.0 .
	
	$ docker run -d --rm --name web-server -p 8080:80 my-php-app:7.0
	
Getting started: Kubernetes
------------------------------
First steps with Kubernetes.
	
	$ kubectl version
		
	$ kubectl get nodes
	
	$ kubectl get pods
	
	$ kubectl get pods --all-namespaces
  
Our first deployment
--------------------

	$ kubectl create deployment web-server --image httpd

	$ kubectl get all

	$ kubectl describe deployment/web-server
	
	$ kubectl get deployment/web-server -o yaml
	
	$ kubectl exec -it deployment/web-server bash
	
	$ kubectl logs deployment/web-server
	
Expose our deployment
---------------------

	$ kubectl port-forward deployment/web-server 8080:80
	
	Browser: http://localhost:8080
	
	$ kubectl expose deployment/web-server --port 8080 --target-port 80 --name httpd
	
	$ kubectl get services httpd -o yaml
	
	$ kubectl describe services httpd

	
	
An aside for Ingress
--------------------
	$ kubectl apply -f techsummit-ingress.yaml
	
	$ kubectl get ingress
	
	$ kubectl describe ingress
	
	Browser: http://sample-php.techsummit
	
Change the image
----------------

	$ kubectl edit deployment/web-server
	
	$ kubectl get pods
	
	$ kubectl describe deployment/web-server
	
Update the replicas
-------------------
Update the number of replicas from 1 to 3.

	$ kubectl edit deployment/web-server

	$ kubectl describe deployment/web-server

View the service and see we now have three endpoints.

	$ kubectl get services
	
	$ kubectl scale --replicas 1 deployment/web-server
	
Tag our image and update
------------------------
Tag (version) our Docker image and then edit the deployment to use this version of our image:

	$ docker build -t my-php-app:7.0 .
		
	$ kubectl edit deployment/web-server
	
	$ kubectl get pods
	
Edit the Dockerfile and change the image from 7.0 to 7.2.

	$ docker build -t my-php-app:7.2 .
	
	$ kubectl edit deployment/web-server
	
Undo the change from the command line.

	$ kubectl rollout undo deployment/web-server
	
Guestbook app... Docker
-----------------------

	$ cd ../guestbook
	
	$ cd docker
	
	$ docker-compose up -d
	
	Browser: http://localhost:8080
	
	$ docker-compose kill
	
Guestbook app... K8s
--------------------

	$ cd ../kubernetes
	
	$ kubectl apply -f guestbook-all-in-one.yaml
	
	Browser: http://guestbook.techsummit
	
	$ kubectl get all
	
	$ kubectl delete -f guestbook-all-in-one.yaml
	
  
