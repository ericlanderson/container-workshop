Script
======

Can be used to copy-paste from here to the Terminal/Powershell instead of all of that typing.

Preliminaries
-------------
```
$ cd container-workshop

$ git pull

$ cd sample-php
```

Getting started
---------------
First steps with Docker.

```
$ docker version

$ docker run hello-world

$ docker pull ubuntu

$ docker run ubuntu
```

Run a container based on the Ubuntu image and start an interactive shell with bash.

```
$ docker run --interactive --tty ubuntu bash

```
The following is executed from within the container.

```
# cat /etc/os-release

# top

# apt update && apt -y install iputils-ping

# ping 1.1.1.1

# exit
```