# Search Facets

This project implements a simple API endpoint with user interface for sidebar search facets.


----
## Technologies
----
- Slim Framwork v4 (API)
- Angular 11.2.10
- Angular Material 11
- Docker / Docker Compose
- NPM
- Composer


----
## Installation
-----
### Slim Framework

- Go to `api/src/`, then run `composer install`.
- After composer installation, go back to `api/` then run `docker-compose up -d`.
- Check if the container is running via `docker ps -a`.
- You should now be able to access it in the browser via `http://localhost:8080`.

### Database Migration
- Go to `http://localhost:8080/adminer`.
- Key in the mysql credentials declared in `docker-compose.yml`, then import `data.sql`.

### Angular
- Go to `frontend/search-facets/`, then run `npm install`.
- After installation on node_modules dependencies, run `npm run start`.


----
## Other options
----
- Nginx vhosts file host naming via `api/nginx/vhosts`

----
## TODOs
----
- Unit tests for Slim
- Build script for seamless first time setup including database migrations
- Karma unit tests for Angular
- Build sript setup for production deployment
