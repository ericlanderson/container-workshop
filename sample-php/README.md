PHP Test site
=============
```
$ docker build -t my-php-app . 
$ curl -s http://localhost

$ curl -s http://localhost/fib.php\?number=10| jq
```