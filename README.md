# 3C Light - Sistema WMS (Warehouse Management System)

Sistema de Gerenciamento de Armazem desenvolvido em PHP para controle completo de operacoes logisticas.

## Sobre o Projeto

O **3C Light** (tambem conhecido como **ARGUS**) e um sistema WMS completo para gestao de armazens, contemplando todas as etapas do processo logistico: recebimento, armazenagem, movimentacao, expedicao e inventario.

## Tecnologias Utilizadas

- **Backend:** PHP 7+
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript, jQuery
- **Framework CSS:** Bootstrap, SmartAdmin
- **Bibliotecas:**
  - PHPMailer (envio de emails)
  - TCPDF / DOMPDF (geracao de relatorios PDF)
  - PHPExcel (importacao/exportacao Excel)
  - jQuery Mobile (interface coletor)

## Estrutura do Projeto

```
light-2026/
├── WMS_PRD/                    # Modulo principal do WMS
│   ├── coletor/                # Interface mobile para coletores
│   ├── data/                   # Processamento de dados e relatorios
│   ├── inventario/             # Gestao de inventario
│   ├── entrega/                # Controle de entregas
│   ├── sap/                    # Integracao SAP
│   ├── config/                 # Configuracoes
│   ├── css/                    # Estilos
│   ├── js/                     # Scripts JavaScript
│   ├── fonts/                  # Fontes
│   └── img/                    # Imagens
├── mon_prc/                    # Monitoramento de processos
├── PHPMailer-master/           # Biblioteca de email
├── report/                     # Relatorios
├── css/                        # Estilos globais
├── js/                         # Scripts globais
├── img/                        # Imagens globais
└── fonts/                      # Fontes globais
```

## Funcionalidades Principais

### Recebimento
- Cadastro de notas fiscais
- Conferencia de mercadorias
- Importacao de XML de NF-e
- Etiquetagem de produtos
- Integracao com SAP

### Armazenagem
- Gestao de enderecos (rua, coluna, altura)
- Alocacao de produtos
- Controle de locais
- Gestao de galpoes e docas

### Expedicao
- Controle de pedidos
- Geracao de ondas de separacao
- Conferencia de expedicao
- Controle de volumes
- Romaneio de entrega

### Inventario
- Inventario ciclico
- Inventario geral
- Inventario cego
- Controle de tarefas
- Acertos de estoque

### Coletor Mobile
- Interface responsiva para dispositivos moveis
- Leitura de codigo de barras
- Conferencia de recebimento
- Conferencia de expedicao
- Movimentacao de produtos
- Consultas de estoque

### Cadastros
- Produtos
- Clientes
- Fornecedores
- Funcionarios
- Empresas
- Grupos e Subgrupos
- Enderecos de armazenagem
- Usuarios e Permissoes

### Relatorios e Dashboards
- Dashboard de ocupacao de estoque
- Dashboard de qualidade
- Dashboard de transporte
- Relatorios de estoque
- Relatorios de movimentacao
- Exportacao para Excel

### Integracoes
- SAP (MB52, pedidos, notas fiscais)
- Email (notificacoes automaticas)
- Importacao de planilhas Excel

## Requisitos do Sistema

- PHP 7.0 ou superior
- MySQL 5.6 ou superior
- Servidor Web (Apache/Nginx)
- Extensoes PHP: mysqli, gd, mbstring, xml

## Instalacao

1. Clone o repositorio:
```bash
git clone https://github.com/clecioalmeida/3C-light.git
```

2. Configure o banco de dados em `WMS_PRD/bd_class.php`:
```php
private $host = 'localhost';
private $usuario = 'seu_usuario';
private $senha = 'sua_senha';
private $database = 'seu_banco';
```

3. Importe a estrutura do banco de dados (scripts SQL nao incluidos - solicitar separadamente)

4. Configure o servidor web para apontar para a pasta do projeto

5. Acesse o sistema pelo navegador

## Modulos do Coletor

O sistema possui interface mobile completa para operacoes com coletor de dados:

| Modulo | Descricao |
|--------|-----------|
| `conf_rec.php` | Conferencia de recebimento |
| `conf_exp.php` | Conferencia de expedicao |
| `alocacao.php` | Alocacao de produtos |
| `inventario.php` | Inventario |
| `consulta.php` | Consultas gerais |
| `movimenta.php` | Movimentacao |

## Autor

**Clecio de Almeida**

## Licenca

Este projeto e proprietario. Todos os direitos reservados.

---

*Sistema desenvolvido para gestao logistica empresarial*
