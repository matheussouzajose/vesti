DOCKER_COMPOSE := docker compose
DOCKER_EXEC := ${DOCKER_COMPOSE} exec app

.DEFAULT_GOAL := help

help:
	@echo "Uso: make [alvo]"
	@echo ""
	@echo "Alvos disponíveis:"
	@echo "  up             Inicia todos os contêineres definidos no Docker Compose"
	@echo "  build          Inicia o Build de todos os contêineres definidos no Docker Compose"
	@echo "  down           Para todos os contêineres"
	@echo "  restart        Reinicia todos os contêineres"
	@echo "  logs           Exibe logs dos contêineres"
	@echo "  exec           Executa um comando em um serviço específico (exemplo: make exec service=comando)"
	@echo "  ps             Lista os contêineres em execução"
	@echo "  test           Roda todos os testes"
	@echo "  help           Exibe esta mensagem de ajuda"

setup:
	${DOCKER_COMPOSE} build & ${DOCKER_COMPOSE} up -d & ${DOCKER_EXEC} composer install;

build:
	${DOCKER_COMPOSE} build;

up:
	${DOCKER_COMPOSE} up -d;

down:
	${DOCKER_COMPOSE} down;

restart:
	${DOCKER_COMPOSE} restart;

logs:
	${DOCKER_COMPOSE} logs -f;

ps:
	${DOCKER_COMPOSE} ps;

exec:
	${DOCKER_EXEC};

composer-install:
	${DOCKER_EXEC} composer install;

test:
	$(DOCKER_EXEC) composer test

.PHONY: help build up down restart logs ps setup test