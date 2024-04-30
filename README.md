# IP box report - generator 

> [!NOTE]
> This project used for generate IP box reports in csv file for selected year.
> If you need generate own reports, you can define own logic in `src/Report/Factory/CompanyReports2024.php`.

## Example report
![example.png](reports%2Fexample.png)

> [!WARNING]
> You need docker for run this project.

## Run project

```sh
docker-compose -f docker/docker-compose.yml up -d
```

## Install packages

```sh
docker-compose -f docker/docker-compose.yml exec php composer install
```

## Generate ip box reports

```sh
docker-compose -f docker/docker-compose.yml exec php php ./bin/console app:IPBoxGenerator year
```

## Run tests

```sh
docker-compose -f docker/docker-compose.yml exec php composer tests
```
