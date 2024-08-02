# PERFORM360 | Controle de Qualidade

## Sobre o Projeto

**PERFORM360** é um sistema baseado em Laravel utilizando Blade e Breeze para autenticação, focado na gestão de qualidade de atendimentos através de avaliações de chamadas telefônicas recebidas na central de atendimento. O sistema possui três tipos de perfis ativos além do perfil de administrador, detalhados a seguir. Todo o sistema é baseado no modelo MVC.

## Perfis de Usuário
### Perfil de Qualidade

**Responsabilidades:**
- Realizar o upload do áudio gerado pela chamada telefônica no sistema.
- O áudio será transcrito com inteligência artificial da OpenAI-Whisper em segundo plano, utilizando Python.
- Após a transcrição do áudio, o perfil é responsável pela categorização da avaliação, identificando, através da transcrição, o número do protocolo, o atendente responsável, o cliente solicitante e o usuário que realizou a chamada.

### Coordenador

**Responsabilidades:**
- Gestão do sistema como um todo.
- Inclusão, edição e exclusão de perfis de usuários.
- Inclusão, edição e exclusão de clientes da central de atendimento.
- Inclusão, edição e exclusão das questões para avaliação, incluindo pontuação e quais questões serão utilizadas para cada cliente.
- Inclusão, edição e exclusão de informativos no quadro de avisos.

### Atendente

**Responsabilidades:**
- Visualizar os painéis do sistema e a relação de avaliações vinculadas ao mesmo.

## Páginas do Sistema
### Página Inicial

**Descrição:** Inclui o dashboard com as informações gerais do sistema e a classificação dos atendentes baseada na pontuação média mensal. Utiliza Highcharts para exibição de gráficos.

### Página de Avaliações

**Descrição:** Contém uma tabela das avaliações organizadas de forma decrescente, do mais recente para o mais antigo.

### Página de Nova Avaliação

**Descrição:** Possui um formulário para inclusão do áudio, iniciando uma nova avaliação com um único input de arquivo.

### Página de Procedimentos

**Descrição:** Contém o roteiro de atendimento que deve ser seguido pelo atendente durante as chamadas telefônicas.
**Futuro:** Implementação do sistema de treinamentos.

### Painel de Avisos

**Descrição:** Contém um carrossel estilo slide com avisos determinados pelo coordenador para a equipe.

### Página de Notificações

**Descrição:** Inicialmente configurada para mostrar a relação de notificações de conclusão das transcrições, gerando um alerta no header da aplicação quando a transcrição feita em segundo plano é finalizada.
**Futuro:** Inclusão de outras notificações de alerta.

### Página de Perfil

**Descrição:** Exibe as informações do perfil do usuário logado, com opção de alteração de senha e visualização do histórico de atendimento vinculados ao perfil.
Páginas de Acesso Restrito aos Coordenadores

### Página de Usuários

**Descrição:** Relação de usuários do sistema em todos os perfis que não sejam administradores, com links para visualização detalhada do perfil de cada usuário, edição, exclusão e visualização do histórico de atendimentos realizados pelo atendente.
**Funcionalidades:** Botão "Novo Usuário" para inclusão de novos usuários do sistema.

### Página de Clientes

**Descrição:** Relação de clientes que o sistema atende, com funcionalidades para inclusão, edição e exclusão de clientes.
**Funcionalidades:** Botão "Novo Cliente" para inclusão de novos clientes.

### Página de Questões

**Descrição:** Dedicada às questões que serão utilizadas como critérios para avaliar cada chamada telefônica.

### Página de Avisos

**Descrição:** Permite que o coordenador insira novos avisos para a equipe, com ou sem imagem, que serão enviados automaticamente para o Painel de Avisos através do back-end da aplicação.

## Funcionalidades do Sistema

**Transcrição de Áudio:** O áudio das chamadas telefônicas é transcrito utilizando a inteligência artificial da OpenAI-Whisper em segundo plano, com suporte de scripts em Python.
Gestão de Perfis: Inclusão, edição e exclusão de perfis de usuários, clientes, questões de avaliação e avisos.
**Avaliação de Chamadas:** Categorização das avaliações com base na transcrição do áudio, identificando o número do protocolo, atendente responsável, cliente solicitante e usuário que realizou a chamada.
**Painel de Avisos:** Exibição de avisos importantes para a equipe, configurados pelo coordenador.
**Notificações:** Sistema de notificações para alertar sobre a conclusão das transcrições e outras futuras funcionalidades.
**Visualização de Dados:** Utilização de Highcharts para exibição de gráficos no dashboard.

## Tecnologias Utilizadas
[**Laravel:**](https://laravel.com/) Framework PHP para desenvolvimento web, verão 11x.
**Blade:** Template engine do Laravel.
**Breeze:** Pacote de autenticação do Laravel.
[**Bootstrap:**](https://getbootstrap.com/) Framework CSS para design responsivo.
[**Highcharts:**](https://www.highcharts.com/) Biblioteca para criação de gráficos interativos.
[**Python:**](https://www.python.org/) Utilizado para scripts de transcrição de áudio, versão compatível - 3.10
[**OpenAI-Whisper:**](https://pypi.org/project/openai-whisper/) Tecnologia de inteligência artificial para transcrição de áudio.

## Versionamento da Documentação
Versão 1.0
Data de Lançamento: 01/08/2024
Descrição: Versão inicial do sistema com as funcionalidades principais descritas na documentação.

Para obter detalhes completos sobre cada versão, consulte o histórico de commits e a documentação de versão no repositório do projeto.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Passos para execução do projeto

Executar a criação das tabelas e chaves estrangeiras

    php artisan migrate

Adição de dados 

    php artisan db:seed

Criação de ambiente virtual para execução do script Python

    python -m venv venv

Ativar o ambiente virtual: venv\Scripts\Activate
    
    Instalar: pip install openai-whisper

Traduzir para portugues
https://github.com/lucascudo/laravel-pt-BR-localization