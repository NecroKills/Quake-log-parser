# Quake Log Parser

####Task 1

O projeto constitui em ser um analisador (parser) para o arquivo de log do jogo Quake 3 Arena.

O arquivo games.log são gerados pelo servidor de Quake 3 Arena. Ele registra todas as informações dos jogos, quando um jogo começa, quando termina, quem matou quem, quem morreu pq caiu no vazio, quem morreu machucado, entre outros.

O parser é capaz de ler o arquivo, agrupar os dados de cada jogo, e em cada jogo deve coletar as informações de morte.

Ao aplicar o parser sobre o arquivo de log, resultará em um json, como apresentado abaixo:

       [
          {
              "game_5": {
                  "total_kills": 14,
                  "players": [
                      "Dono da Bola",
                      "Isgalamido",
                      "Zeh",
                      "Assasinu Credi"
                  ],
                  "kills": {
                      "Isgalamido": 2,
                      "Assasinu Credi": -3,
                      "Zeh": 1
                  }
              }
          },
        ]

#### Executando o projeto

Para a execução do projeto localmente, siga os comandos abaixo no terminal:

    $ git clone https://github.com/NecroKills/Quake-log-parser.git
    $ cd quake-log-parser
    $ npm install
    $ php artisan serve

###### Observações

- Foi utilizado para o desenvolvimento do projeto o framework laravel versão "5.4"
