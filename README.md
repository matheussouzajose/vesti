### Introdução:
Este projeto foi desenvolvido como parte do processo de candidatura para a vaga de desenvolvedor.
Sua missão portanto é construir um hub que consuma API’s de Sistemas ERP’s e insira
suas informações no Vesti também através de API’s.

### Tecnologias Utilizadas:
- **Docker:** Docker foi selecionado para containerizar o aplicativo, o que permite um ambiente de desenvolvimento isolado.
- **Nginx:** Nginx foi selecionado como um proxy reverso para direcionar solicitações HTTP para o aplicativo Laravel.
- **Slim:** Slim foi selecionado para construir uma Api devido à sua facilidade de uso.

### Clean Architecture:
O projeto foi desenvolvido seguindo os princípios da Clean Architecture. Isso envolve a separação das camadas de aplicação em:
- **Entidades:** Entidades de negócios, como a entidade "Produto" no contexto deste aplicativo.
- **Casos de Uso:** Implementação dos casos de uso, que representam as operações Cadastrar produtos.
- **Ui/Controladores:** Os controladores foram criados para lidar com as solicitações HTTP e interagir com os casos de uso.
- **Infrastrucuture:** Utilizado na camada de Frameworks e Drivers, especialmente para lidar com a infraestrutura web.

### Estrutura do Projeto:
Importante:
- **src**
    - **Application:** Casos de Uso
    - **Domain:** Entidades
    - **Infrastructure:** Interação com biblioteca externas.
    - **Ui:** Controllers

### Funcionalidades:
- **[POST] - [Cadastrar Produtos]** http://localhost:8000/api/v1/products/{companyId}

Obs: Será necessário para no Header o `ApiKey: Token` e no parâmetro o `id` da empresa.
Infelizmente, a tentativa de realizar o teste de cadastro na API da Vesti não foi bem-sucedida devido a problemas com 
as credenciais fornecidas. No entanto, a aplicação está totalmente preparada para integrar-se à API utilizando as credenciais adequadas.

### Testes:
- Testes automatizados para garantir a qualidade do código e o funcionamento adequado do aplicativo.

### Conclusão:
Em resumo, este projeto demonstra a minha capacidade de desenvolver e implementar uma aplicaçã utilizando tecnologias
modernas e boas práticas de desenvolvimento.

Além disso, a implementação da Clean Architecture ajudou a manter uma clara separação de preocupações em todas
as camadas do aplicativo, tornando-o altamente testável e adaptável para futuros aprimoramentos.

Este projeto é um reflexo do meu comprometimento em desenvolver soluções de alta qualidade e escaláveis, seguindo as melhores práticas.

### Como utilizar:
Para iniciar os serviços, clone o projeto e abra um terminal na raiz e execute o seguinte comando via Makefile:

### Com Makefile
- Para construir as imagens, subir e instalar as dependências. (Sugerido)
```make
make setup
```

- Para construir as imagens do Docker Compose:
```make
make build
```

- Para iniciar o Docker Compose:
```make
make up
```

- Para parar o Docker Compose:
```make
make down
```

- O comando make tests é utilizado para executar os testes dentro do container
```make
make test
```

- Para visualizar outras opções de comandos
```make
make help
```