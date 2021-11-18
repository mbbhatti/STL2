#!/bin/bash
docker network create acud2test-net
docker run --rm --name acud2testmariadb --env-file .docker/testDB.env -d --network acud2test-net mariadb:10.4
docker build -f .docker/test.Dockerfile -t acud2backendtest .
docker run --rm --network acud2test-net -v $(pwd)/var:/app/var:delegated acud2backendtest
TESTRESULT=$?
docker stop acud2testmariadb || true
docker network rm acud2test-net || true
docker rmi acud2backendtest || true
exit $TESTRESULT
