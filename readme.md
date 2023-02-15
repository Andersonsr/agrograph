# Agrograph
O agrograph é uma plataforma para armazenamento de dados geolocalizados desenvolvida para atender as necessidades da agricultura de precisão, desenvolvido em PHP e faz uso do banco de dados orientado a grafos Neo4j

As funcionalidades bem como o processo de desenvolvimento estão documentados no seguinte artigo: https://publicaciones.sadio.org.ar/index.php/JAIIO/article/view/418

Uma breve apresentação da plataforma 
https://youtu.be/S6GAsUKy5rM

## Instalação
Para rodar a aplicação em sua própira máquina com a finalidade de testar suas funcionalidades, siga os seguintes passos:  

1. Executar o comando `docker compose up` dentro  diretório agrograph.
2. Executar a query `CALL spatial.addPointLayer('layer');` no cliente Neo4j disponível em http://localhost:7474, o usuário é iniciado como `neo4j` e a senha `123456`.  
3. Pronto, é só isso mesmo a maior parte do trabalho quem faz é o querido docker. 

### Troca de Senha
Caso troque a senha do banco de dados, dois arquivos devem ser modificados para que a aplicação continue funcionando. 

1. O arquivo `BDAP/connect.php ` linha 11.
2. O arquivo `agrograph-api/agrograph/settings.py` linha 77 contido no container agrograph-python.