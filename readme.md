# Agrograph
O agrograph é uma plataforma para armazenamento de dados geolocalizados desenvolvida para atender as necessidades da agricultura de precisão, desenvolvido em PHP e faz uso do banco de dados orientado a grafos Neo4j

As funcionalidades bem como o processo de desenvolvimento estão documentados no seguinte artigo: https://publicaciones.sadio.org.ar/index.php/JAIIO/article/view/418

Uma breve apresentação da plataforma 
https://youtu.be/S6GAsUKy5rM

A API do agrograph ainda está em desevolvimento pode ser encontrada no seguinte link: https://github.com/Andersonsr/agrograph-api 

## Instalação
Para rodar a aplicação em sua própira máquina com a finalidade de testar suas funcionalidades, siga os seguintes passos:  

1. Executar o comando `docker compose up` dentro  diretório agrograph.

2. O compose up pode receber alguma variaveis de ambiente. Para usar o container do neo4j como banco de dados mude o NEO4J_HOST para o nome do container, o nome default é `agrograph-neo4j-1`.  
    ```
    NEO4J_HOST=agrograph-neo4j-1 NEO4J_USER=neo4j NEO4J_PASSWORD=123456 SECRET=supersecret docker compose up
    ```
3. Pronto, é só isso mesmo a maior parte do trabalho quem faz é o querido docker. 

