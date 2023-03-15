## Test task

To start it locally need clone repository to local environment:

``git clone git@github.com:glembus/xm-test.git`` 

Then got to the project folder:

``cd xm-test``

Run make command ``make install`` or use docker compose ``docker-compose up -d``

Make install wil run all containers and install composer dependencies. It will only left to run ``npm install`` and 
``npm run build`` in project dir.

If project was started using ``docker-compose`` then will need to run composer install in container:

``docker exec -it <container_name> bash`` and in container run ``composer install``, ``npm install``, and ``npm run build``

Open browser and type localhost in address line. That's all.
