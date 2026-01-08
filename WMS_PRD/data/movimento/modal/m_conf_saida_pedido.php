<div class="modal fade" id="conf_cadastro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #A52A2A;">
                <h4 class="modal-title" id="myModalLabel" style="color: white">Erro!</h4>
            </div>
            <div class="modal-body">                                
                <h4>Tem certeza que deseja sair da inclusão de produtos? </h4><br /><br />
                <button type="submit" id="btnPedSaidaIncProduto" class="btn btn-danger btn-sm" value="">Sim</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
            </div>
            <div class="modal-footer" style="background-color: #A52A2A;">
                
            </div>
        </div>
    </div>
</div>         
<script>
    $(document).ready(function () {
        $('#conf_cadastro').modal('show');
    });

    $(document).on('click', '#btnPedSaidaIncProduto', function(){
        event.preventDefault();
         $('#retorno').load('data/movimento/modal/m_success_saida_pedido.php');
    });
</script>