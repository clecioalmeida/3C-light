<div class="modal fade" id="inserir_ocorrencia" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          &times;
        </button>
        <h4 class="modal-title" style="color: white">Inserir ocorrência</h4>
      </div>
      <div class="modal-body modal-md" style="overflow-y: auto">
        <div class="form-body">
          <div class="widget-body no-padding">
            <form id="formNovaOcor" class="smart-form" method="POST" action="" novalidate="novalidate">
             <fieldset>
              <div class="row">
                <section class="col col-5">
                  <label class="select"> <!--i class="icon-prepend fa fa-circle"></i-->
                    <select name="criticidade">
                     <option select disabled="false">Selecione a criticidade</option>
                     <option value="A">Alta</option>
                     <option value="M">Média</option>
                     <option value="B">Baixa</option>
                   </select>
                 </label>
               </section>
               <section class="col col-5">
                <label class="select"> <!--i class="icon-prepend fa fa-circle"></i-->
                 <select name="tipo">
                   <option value="0" select disabled="false">Selecione a origem</option>
                   <option value="A">Armazém</option>
                   <option value="T">Transporte</option>
                   <option value="G">Agendamento</option>
                   <option value="O">Outros</option>
                 </select>
               </label>
             </section>
           </div>
           <div class="row">
            <section class="col col-5">
              <label class="input"> <i class="icon-prepend fa fa-list"></i>
                <input type="text" name="cod_origem" placeholder="Código de origem">
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-10">
              <label class="input"> <i class="icon-prepend fa fa-list"></i>
                <input type="text" name="nm_ocorrencia" placeholder="Descrição">
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-5">
              <label class="input"> <i class="icon-prepend fa fa-user"></i>
                <input type="text" name="ds_responsavel" placeholder="Responsável">
              </label>
            </section>
            <section class="col col-5">
              <label class="input"> <i class="icon-prepend fa fa-list"></i>
                <input type="text" name="nm_depto" placeholder="Departamento" >
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-5">
              <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                <input type="date" name="dt_final" placeholder="Data final para solução">
              </label>
            </section>
            <section class="col col-5">

            </section>
          </div>
          <div class="row">
            <section class="col col-10">
              <label class="input">
                <textarea class="form-control" name="ds_obs" placeholder="Observações" rows="5"> </textarea>
              </label>
            </section>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
<div class="modal-footer modal-lg" style="background-color: #22262E">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
  <button type="submit" id="btnNewOcor" class="btn btn-success">Salvar</button>
</div>
</div>
</div>
</div>
<script>
  $(document).ready(function () {
    $('#inserir_ocorrencia').modal('show');
  });
</script>
<!--script type="text/javascript">
    $('#btnIns').click(function(){
        $('#formIns').ajaxForm({
            target:'#inserir_ocorrencia',
            url:'ins_ocorrencia.php',
        });
    });
</script-->