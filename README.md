# Teste MUPER

## Resumo

Este projeto é uma aplicação PHP que foi desenvolvida para decodificar informações GPS a partir de um arquivo de log retornar um json para que esses dados sejam manipulados mais facilmente.

Os dados são emitidos diretos no terminal e também são salvos na pasta files, na raiz do projeto

## Tecnologias e Versões

- **PHP**: 7.4
- **Composer**: 2.8.5
- **Docker**: 20.x
- **Docker Compose**: v2.18.1
- **Outras dependências**: Arquivo de log

## Requisitos

- **Docker**: Certifique-se de que o Docker esteja instalado em sua máquina. Se você ainda não o tem, pode obter no [site oficial do Docker](https://www.docker.com/products/docker-desktop).
- **Docker Compose**: O Docker Compose é necessário para orquestrar os containers. Você pode instalar o Docker Compose seguindo as instruções do [site oficial do Docker Compose](https://docs.docker.com/compose/install/).

## Rodando o Projeto com Docker

### Passo 1: Clonar o repositório

Primeiro, faça o clone deste repositório em sua máquina local:

```bash
git clone https://github.com/JadisDev/muper.git
cd muper
```

### Passo 2:

```bash
docker-compose build --no-cache
docker-compose up

Para destruir: docker-compose down
```