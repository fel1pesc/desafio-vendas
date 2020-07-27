Ola! 

Nesse repositório temos um desafio que foi desenvolvido com a ideia de ser um sistema bem básico, onde o usuário pode cadastrar Vendas dos Itens que também são cadastrados no sistema.

Na parte do design da página, utilizei bootstrap e escolhi desenvolver um template do zero, que acabou custando um pouco mais de tempo do que o esperado por mim, mas na minha visão, consegui deixar um design bem simples, organizado e enxuto/clean. 

No código back-end utilizei o padrão MVC, com uma estrutura de Repositories que estende de uma classe abstrata (chamada de RepositoryBase). Nas Repositories, eu tenho estruturada toda a parte de querys que é incluida no sistema.



1º - Para gerar a APP_KEY no arquivo .env:	
php artisan key:generate

2º - Para baixar/atualizar as dependências:
composer update

3º - Para rodar as migrations e executar a(s) seed(s) criadas:
php artisan migrate --seed

4º - Para gerar as keys utilizadas nos tokens utilizados na API
php artisan passport:install


Usuário para acessar o sistema:

Login: desafio@softcom.com.br
Senha: softcom


Qualquer dúvida só entrar em contato!