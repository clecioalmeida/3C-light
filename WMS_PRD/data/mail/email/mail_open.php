<?php
$msg_id=$_POST['msg_id'];
$subject=$_POST['subject'];
$remetente=$_POST['remetente'];
$data=$_POST['data_mail'];

date_default_timezone_set('America/Sao_Paulo');

$mbox = imap_open("{mx1.hostinger.com.br:993/imap/ssl/novalidate-cert/readonly}INBOX", "teste@growupsti.com.br", "teste2017");

$nlidas = imap_num_recent($mbox);

$folders = imap_listmailbox($mbox, "{mx1.hostinger.com.br:993/imap/ssl/novalidate-cert/readonly}", "*");

$body = imap_fetchbody($mbox, $msg_id,'1', FT_UID);

//$headerinfo2         = imap_headerinfo($mbox, $msg_id);
//$subject            = $headerinfo2->subject;
//$remetente          = $headerinfo2->fromaddress;
//$data               = $headerinfo->date;
//$data               = strtotime($data);
//$data               = date("d/m/Y H:i:s", $data);
?>
<div class="modal fade" id="mailDtl" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header" style="background-color: #57889c">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          &times;
        </button>
        <h4 class="modal-title" style="color: white"></h4>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <p><?php echo $msg_id;?></p>
        <h2 class="email-open-header">
          <h6><strong>Assunto:</strong></h6><?php echo $subject;?> <span class="label txt-color-white">inbox</span>
          <a href="javascript:void(0);" rel="tooltip" data-placement="left" data-original-title="Print" class="txt-color-darken pull-right"><i class="fa fa-print"></i></a> 
        </h2>
        <div class="inbox-info-bar" style="width: 100%">
          <div class="row">
            <div class="col-sm-9">
              <span class="hidden-mobile">&lt;<?php echo $remetente;?>&gt; <strong>em</strong>  <i><?php echo $data;?></i></span> 
            </div>
            <div class="col-sm-3 text-right">

              <div class="btn-group text-left">
                <button class="btn btn-primary btn-sm replythis">
                  <i class="fa fa-reply"></i> Reply
                </button>
                <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right">
                  <li>
                    <a href="javascript:void(0);" class="replythis"><i class="fa fa-reply"></i> Reply</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);" class="replythis"><i class="fa fa-mail-forward"></i> Forward</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);"><i class="fa fa-print"></i> Print</a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a href="javascript:void(0);"><i class="fa fa-ban"></i> Mark as spam!</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);"><i class="fa fa-trash-o"></i> Delete forever</a>
                  </li>
                </ul>
              </div>

            </div>
          </div>
        </div>
        <div class="inbox-message" style="width: 100%">
          <p>
            <h2><strong>Mensagem:</strong></h2><?php echo $body;?>
          </p>
          <br>
        </div>

      </div>
      <div class="modal-footer modal-lg" style="background-color: #57889c">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <span class="fa fa-close" aria-hidden="true"></span>Fechar</button>
        <button type="button" class="btn btn-primary" id="btnSaveTVenda">
          <span class="fa fa-floppy-o" aria-hidden="true"></span>
          Salvar
        </button>
      </div>
    </div>
  </div>
</div><!--Fim modal-->
<script>
  $(document).ready(function () {
    $('#mailDtl').modal('show');
  });
</script>