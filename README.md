# Sweet Bonus 

Páginas de cadastro e funil.

## Instalar em servidor local

Siga os seguintes passos para rodar o projeto em seu ambiente local de desenvolvimento.

#### 1. Clone o projeto para seu repositório local

#### 2. Faça o setup do arquivo .env

Copie o arquivo *.env.example*, renomeando para *.env*. Além das padrões, as propriedades abaixo deverão estar presentes: 

`STORE_URL=` Informe a URL da store.

`APP_STORAGE=` Local onde ficará armazenado as mídias das campanhas.

`APP_SWEET_API=` Informe o endereço da API do projeto.

Para disparo de e-mail transacional, as seguintes propriedades devem ser informadas: 
`ALLIN_USER=` e `ALLIN_PASS=` - para o provedor Allin, `INBOXCENTER_DOMAIN=`, `INBOXCENTER_EMAIL=`, `INBOXCENTER_API=` e `INBOXCENTER_TOKEN=` - para o Inbox Center.


#### 3. Atualize seu projeto
Digite o comando `composer update` dentro da pasta.

#### 4. Adicione o projeto ao Homestead
Para que o projeto rode no Homestead, é necessário incluir as informações no arquivo *Homestead.yaml*.  

Exemplo de configuração para folders:

    folders: 
       - map: C:/www/sweetbonus
         to: /home/vagrant/Sites/sweetbonus.test

Exemplo de configuração para sites:

    sites: 
       - map: sweetbonus.test
         to: /home/vagrant/Sites/sweetbonus.test/public
         schedule: true   

Lembre-se também de configurar o arquivo de *hosts* do seu sistema operacional. Veja o exemplo abaixo: 

    192.168.10.10	sweetbonus.test

