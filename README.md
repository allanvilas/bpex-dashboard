# BPEX DASHBOARD

## Setup

### .env vars

- env vars obrigatórias para executar o projeto:
    - DB_HOST=
    - DB_PORT=
    - DB_DATABASE=
    - DB_USERNAME=
    - DB_PASSWORD=
    - DB_ROOT_PASSWORD=
    - EXTRACTOR_API_KEY=
    - EXTRACTOR_ENDPOINT_URL= 
    - WEBSOCKET_SERVER_URL= 'ws://XXX:XXX'
    - ADMIN_FIRST_ACCESS_PASSWORD=


### Processo de Run

#### Executar o docker composer para inciar o banco de dados

- dentro da pasta do projeto execute:

```bash
    docker compose up -d --build
```

#### Executar a migration para setup inicial dos usuários

-> Dentro do projeto execute o comando 

```bash
    php spark migrate
```

#### Em um pash inicie o servidor websocker

-> Dentro do projeto execute o comando para iniciar o servidor websocket:

```bash
    php app\WebSocket\Server.php
```

#### Iniciando o Dashboard

-> Dentro do projeto execute o comando para iniciar o servidor websocket:

```bash
    php spark serve
```