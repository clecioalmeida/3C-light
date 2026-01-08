# Contexto do Projeto - 3C Light WMS

## Informacoes Gerais
- **Nome:** 3C Light (ARGUS)
- **Tipo:** Sistema WMS (Warehouse Management System)
- **Linguagem:** PHP 7+
- **Banco de Dados:** MySQL (logistica3c_wms_light)
- **Repositorio:** https://github.com/clecioalmeida/3C-light

## Estrutura Principal

```
light-2026/
├── WMS_PRD/           # Modulo principal WMS
│   ├── coletor/       # Interface mobile coletores
│   ├── data/          # Processamento dados/relatorios
│   ├── inventario/    # Gestao inventario
│   ├── entrega/       # Controle entregas
│   ├── sap/           # Integracao SAP
│   ├── config/        # Configuracoes
│   └── bd_class.php   # Conexao banco de dados
├── mon_prc/           # Monitoramento processos
├── PHPMailer-master/  # Biblioteca email
├── index.php          # Pagina login principal
├── valida_usuario.php # Validacao de login
└── bd_class.php       # Conexao BD raiz
```

## Modulos Principais

### Recebimento
- `novo_recebimento.php` - Cadastro NF
- `ins_recebimento.php` - Inserir recebimento
- `edit_recebimento.php` - Editar recebimento
- `dtl_recebimento.php` - Detalhes recebimento
- `ins_xml_nf.php` - Importar XML NF-e

### Expedicao
- `pedido.php` / `pedido_new.php` - Gestao pedidos
- `edit_pedido.php` - Editar pedido
- `onda.php` - Ondas de separacao
- `expede.php` - Expedicao
- `controle_pedido.php` - Controle pedidos

### Estoque
- `estoque.php` - Gestao estoque
- `cons_estoque.php` - Consulta estoque
- `endereco.php` - Enderecos armazenagem
- `local.php` - Locais
- `alocacao.php` - Alocacao produtos

### Inventario
- `inv_prog.php` - Inventario programado
- `inv_tarefa.php` - Tarefas inventario
- `inv_param.php` - Parametros inventario
- `hist_inv.php` - Historico inventario

### Coletor Mobile (WMS_PRD/coletor/)
- `index.php` - Login coletor
- `home.php` - Menu principal
- `conf_rec.php` - Conferencia recebimento
- `conf_exp.php` - Conferencia expedicao
- `alocacao.php` - Alocacao
- `inventario.php` - Inventario
- `consulta.php` - Consultas
- `movimenta.php` - Movimentacao

### Cadastros
- `produto.php` / `produto_new.php` - Produtos
- `cliente.php` - Clientes
- `fornecedor.php` - Fornecedores
- `empresa.php` - Empresas
- `usuarios.php` - Usuarios
- `funcionario.php` - Funcionarios

### Dashboards
- `dashboard.php` - Dashboard principal
- `dash_estoque.php` - Dashboard estoque
- `dash_ocupa_estoque.php` - Ocupacao estoque
- `dash_qld.php` - Dashboard qualidade
- `dash_tran.php` - Dashboard transporte

## Bibliotecas Utilizadas
- PHPMailer - Envio de emails
- TCPDF/DOMPDF - Geracao PDF
- PHPExcel - Import/Export Excel
- jQuery Mobile - Interface coletor
- Bootstrap/SmartAdmin - Frontend

## Integracoes
- SAP (MB52, pedidos, NF)
- Email (notificacoes)
- Excel (importacao dados)

## Padroes de Codigo

### Conexao Banco de Dados
```php
include 'bd_class.php';
$obj = new db();
$con = $obj->conecta_mysql();
```

### Consultas SQL
```php
$sql = "SELECT * FROM tabela WHERE campo = '$valor'";
$qr = mysqli_query($con, $sql);
while($ln = mysqli_fetch_assoc($qr)) {
    // processar dados
}
```

## Historico de Alteracoes

| Data | Alteracao | Arquivos |
|------|-----------|----------|
| 2026-01-08 | Criacao repositorio GitHub | - |
| 2026-01-08 | Documentacao README.md | README.md |
| 2026-01-08 | Contexto CLAUDE.md | CLAUDE.md |

---

## Instrucoes para Desenvolvimento

**IMPORTANTE:** Antes de qualquer alteracao:
1. Mostrar ao usuario o que sera ajustado
2. Aguardar aprovacao
3. Fazer a alteracao
4. Documentar no CLAUDE.md (Historico de Alteracoes)
5. Commitar com mensagem descritiva
