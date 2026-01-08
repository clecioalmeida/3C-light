<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

// Require da classe de conexão
require '../bd/conect.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

$cod_rec  = trim(strip_tags($_POST['cod_rec']));

$ds_email = "agendamento3c@argussistemas.com.br";
$email_copia = "recebenfe.edpbr@edpbr.com.br";
$email_copia2 = "eduardo.menocio@3cservices.com.br";

$diretorio = "../xml/";

if (!is_dir($diretorio)) {

    echo "Pasta $diretorio nao existe";
    
} else {

    $arquivo = isset($_FILES['arquivos']) ? $_FILES['arquivos'] : FALSE;

    for ($controle = 0; $controle < count($arquivo['name']); $controle++) {

        $destino = $diretorio . "/" . $arquivo['name'][$controle];
        $FileType = strtolower(pathinfo($destino, PATHINFO_EXTENSION));

        if ($FileType != "xml") {

            echo "Somente arquivos XML são permitidos.";
        } else {


            if (move_uploaded_file($arquivo['tmp_name'][$controle], $destino)) {

                echo "Upload realizado com sucesso<br>";

                $nome = $arquivo['name'][$controle];

                $origem = $diretorio . $arquivo['name'][$controle];

                echo $origem . "<br>";

                $Arrxml = simplexml_load_file($origem);

                echo $Arrxml . "<br>";

                foreach ($Arrxml->NFe as $key => $xml) {
                    $nr_nf_formulario     = $xml->infNFe->ide->nNF;
                    $nr_serie             = $xml->infNFe->ide->serie;
                    $nr_cfop             = $xml->infNFe->det->prod->CFOP;
                    $dt_emissao         = $xml->infNFe->ide->dhEmi;
                    $ds_nat_op             = $xml->infNFe->ide->natOp;
                    $nm_cliente         = $xml->infNFe->emit->xNome;
                    $nm_fantasia         = $xml->infNFe->emit->xFant;
                    $nr_cnpj             = $xml->infNFe->emit->CNPJ;
                    $nr_ie                 = $xml->infNFe->emit->IE;
                    $ds_endereco         = $xml->infNFe->emit->enderEmit->xLgr;
                    $numero             = $xml->infNFe->emit->enderEmit->nro;
                    if ($numero > 0) {

                        $nr_numero = $numero;
                    } else {

                        $nr_numero = 0;
                    }
                    $ds_bairro             = $xml->infNFe->emit->enderEmit->xBairro;
                    $ds_cidade             = $xml->infNFe->emit->enderEmit->xMun;
                    $ds_uf                 = $xml->infNFe->emit->enderEmit->UF;
                    $nr_telefone         = $xml->infNFe->emit->enderEmit->fone;
                    $ds_cep             = $xml->infNFe->emit->enderEmit->CEP;
                    $cod_mun_org         = $xml->infNFe->emit->enderEmit->cMun;
                    $nm_destinatario     = $xml->infNFe->dest->xNome;
                    $nr_cnpj_dest         = $xml->infNFe->dest->CNPJ;
                    $nr_ie_dest         = $xml->infNFe->dest->IE;
                    $ds_endereco_dest     = $xml->infNFe->dest->enderDest->xLgr;
                    $numero_dest         = $xml->infNFe->dest->enderDest->nro;
                    if ($numero_dest > 0) {

                        $nr_numero_dest = $numero_dest;

                    } else {

                        $nr_numero_dest = 0;

                    }
                    $ds_bairro_dest     = $xml->infNFe->dest->enderDest->xBairro;
                    $ds_cidade_dest     = $xml->infNFe->dest->enderDest->xMun;
                    $ds_uf_dest         = $xml->infNFe->dest->enderDest->UF;
                    $ds_cep_dest         = $xml->infNFe->dest->enderDest->CEP;
                    $cod_mun_dest         = $xml->infNFe->dest->enderDest->cMun;
                    $nr_telefone_dest     = $xml->infNFe->dest->enderDest->fone;
                    $nr_peso             = $xml->infNFe->transp->vol->pesoB;
                    $vl_mercadoria         = $xml->infNFe->total->ICMSTot->vNF;
                    $nr_volume             = $xml->infNFe->transp->vol->qVol;
                    $tp_vol             = $xml->infNFe->transp->vol->esp;
                    $item                 = $xml->infNFe->det->prod->cProd;

                    foreach ($Arrxml->protNFe as $key => $chave) {
                        $nfe_chave = $chave->infProt->chNFe;
                    }

                    $sql_rem = "select cod_cliente, nm_cliente ";
                    $sql_rem .= "from tb_cliente ";
                    $sql_rem .= "where nr_cnpj_cpf = ?";
                    $stm = $conexao->prepare($sql_rem);
                    $stm->bindValue(1, $nr_cnpj);
                    $stm->execute();
                    $count = $stm->rowCount();

                    if ($count > 0) {

                        $row = $stm->fetch(PDO::FETCH_ASSOC);

                        $nm_cliente     = $row['nm_cliente'];
                        $cod_cliente    = $row['cod_cliente'];

                        echo '<hr>';
                        echo 'Remetente ' . $nm_cliente . ' já existe.<br>';

                    } else {

                        $fl_tipo    = 'E';
                        $fl_status  = 'A';

                        $insert = "INSERT INTO tb_cliente ";
                        $insert .= "(nm_cliente, nr_cnpj_cpf, ds_ie_rg,  ds_endereco, nr_numero, ds_bairro, ds_cidade, cod_mun, ds_cep, ds_uf, nr_telefone, nm_fantasia, fl_tipo, fl_status) VALUES ";
                        $insert .= "(:nm_cliente,:nr_cnpj_cpf,:ds_ie_rg,:ds_endereco,:nr_numero,:ds_bairro,:ds_cidade,:cod_mun,:ds_cep,:ds_uf,:nr_telefone,:nm_fantasia,:fl_tipo,:fl_status)";
    
                        $result = $conexao->prepare($insert);
                        $result->bindParam(':nm_cliente', $nm_cliente, PDO::PARAM_STR);
                        $result->bindParam(':nr_cnpj_cpf', $nr_cnpj, PDO::PARAM_STR);
                        $result->bindParam(':ds_ie_rg', $nr_ie, PDO::PARAM_STR);
                        $result->bindParam(':ds_endereco', $ds_endereco, PDO::PARAM_STR);
                        $result->bindParam(':nr_numero', $nr_numero, PDO::PARAM_STR);
                        $result->bindParam(':ds_bairro', $ds_bairro, PDO::PARAM_STR);
                        $result->bindParam(':ds_cidade', $ds_cidade, PDO::PARAM_STR);
                        $result->bindParam(':cod_mun', $cod_mun_org, PDO::PARAM_STR);
                        $result->bindParam(':ds_cep', $ds_cep, PDO::PARAM_STR);
                        $result->bindParam(':ds_uf', $ds_uf, PDO::PARAM_STR);
                        $result->bindParam(':nr_telefone', $nr_telefone, PDO::PARAM_STR);
                        $result->bindParam(':nm_fantasia', $nm_fantasia, PDO::PARAM_STR);
                        $result->bindParam(':fl_tipo', $fl_tipo, PDO::PARAM_STR);
                        $result->bindParam(':fl_status', $fl_status, PDO::PARAM_STR);
                        if ($result->execute()) {

                            echo 'Remetente ' . $nm_cliente . ' cadastrado.<br>';
                        
                        } else {
                        
                            echo 'Erro no cadastro do remetente.<br>';
                        }
                    }

                    $sql_dest = "select cod_cliente, nm_cliente ";
                    $sql_dest .= "from tb_cliente ";
                    $sql_dest .= "where nr_cnpj_cpf = ?";
                    $stm_dest = $conexao->prepare($sql_dest);
                    $stm_dest->bindValue(1, $nr_cnpj_dest);
                    $stm_dest->execute();
                    $count_dest = $stm_dest->rowCount();

                    if ($count_dest > 0) {

                        $row_dest = $stm_dest->fetch(PDO::FETCH_ASSOC);

                        $nm_destinatario_cad    = $row_dest['nm_cliente'];
                        $cod_dst                = $row_dest['cod_cliente'];

                        echo '<hr>';
                        echo 'Destinatário ' . $nm_destinatario_cad . ' já existe.<br>';

                    } else {

                        $fl_tipo    = 'D';
                        $fl_status  = 'A';

                        $insert_dest = "INSERT INTO tb_cliente ";
                        $insert_dest .= "(nm_cliente, nr_cnpj_cpf, ds_ie_rg,  ds_endereco, nr_numero, ds_bairro, ds_cidade, cod_mun, ds_cep, ds_uf, nr_telefone,fl_tipo, fl_status) VALUES ";
                        $insert_dest .= "(:nm_cliente,:nr_cnpj_cpf,:ds_ie_rg,:ds_endereco,:nr_numero,:ds_bairro,:ds_cidade,:cod_mun,:ds_cep,:ds_uf,:nr_telefone,:fl_tipo,:fl_status)";
    
                        $result_dest = $conexao->prepare($insert_dest);
                        $result_dest->bindParam(':nm_cliente', $nm_destinatario, PDO::PARAM_STR);
                        $result_dest->bindParam(':nr_cnpj_cpf', $nr_cnpj_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':ds_ie_rg', $nr_ie_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':ds_endereco', $ds_endereco_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':nr_numero', $nr_numero_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':ds_bairro', $ds_bairro_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':ds_cidade', $ds_cidade_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':cod_mun', $cod_mun_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':ds_cep', $ds_cep_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':ds_uf', $ds_uf_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':nr_telefone', $nr_telefone_dest, PDO::PARAM_STR);
                        $result_dest->bindParam(':fl_tipo', $fl_tipo, PDO::PARAM_STR);
                        $result_dest->bindParam(':fl_status', $fl_status, PDO::PARAM_STR);
                        if ($result_dest->execute()) {

                            echo 'Destinatário ' . $nm_destinatario . ' cadastrado.<br>';
                        
                        } else {
                        
                            echo 'Erro no cadastro do destinatário.<br>';
                        }
                    }

                    $sql_nf = "select cod_nf_entrada, nr_fisc_ent ";
                    $sql_nf .= "from tb_nf_entrada ";
                    $sql_nf .= "where id_rem = ? and nr_fisc_ent = ?";
                    $stm_nf = $conexao->prepare($sql_nf);
                    $stm_nf->bindValue(1, $cod_rem);
                    $stm_nf->bindValue(2, $nr_nf_formulario);
                    $stm_nf->execute();
                    $count_nf = $stm_nf->rowCount();

                    if ($count_nf > 0) {

                        $row_nf = $stm_nf->fetch(PDO::FETCH_ASSOC);

                        $n_fiscal    = $row_nf['nr_fisc_ent'];

                        echo '<hr>';
                        echo 'Nota fiscal ' . $n_fiscal . ' já foi importada anteriormente, ';
                    
                    } else {

                        $fl_tipo    = 'D';
                        $fl_status  = 'A';

                        $insert_nf = "INSERT INTO tb_nf_entrada ";
                        $insert_nf .= "(nr_fisc_ent,id_rem,id_dest,dt_emis_ent,chavenfe,nr_peso_ent,vl_tot_nf_ent,qtd_vol_ent,tp_vol_ent,cod_rec,ds_arquivo,fl_status) VALUES ";
                        $insert_nf .= "(:nr_fisc_ent,:id_rem,:id_dest,:dt_emis_ent,:chavenfe,:nr_peso_ent,:vl_tot_nf_ent,:qtd_vol_ent,:tp_vol_ent,:cod_rec,:ds_arquivo,fl_status)";
    
                        $result_nf = $conexao->prepare($insert_nf);
                        $result_nf->bindParam(':nr_fisc_ent', $nr_nf_formulario, PDO::PARAM_STR);
                        $result_nf->bindParam(':id_rem', $cod_rem, PDO::PARAM_STR);
                        $result_nf->bindParam(':id_dest', $cod_dst, PDO::PARAM_STR);
                        $result_nf->bindParam(':dt_emis_ent', $dt_emissao, PDO::PARAM_STR);
                        $result_nf->bindParam(':chavenfe', $nfe_chave, PDO::PARAM_STR);
                        $result_nf->bindParam(':nr_peso_ent', $nr_peso, PDO::PARAM_STR);
                        $result_nf->bindParam(':vl_tot_nf_ent', $vl_mercadoria, PDO::PARAM_STR);
                        $result_nf->bindParam(':qtd_vol_ent', $nr_volume, PDO::PARAM_STR);
                        $result_nf->bindParam(':tp_vol_ent', $tp_vol, PDO::PARAM_STR);
                        $result_nf->bindParam(':cod_rec', $cod_rec, PDO::PARAM_STR);
                        $result_nf->bindParam(':ds_arquivo', $nome, PDO::PARAM_STR);
                        $result_nf->bindParam(':fl_status', $fl_status, PDO::PARAM_STR);

                        $result_nf->execute();

                        $nova_nf = $conexao->lastInsertId();
                        $count_res = $result_nf->rowCount();
    
                        $semResultado = 0;

                        for ($i = 0; $i <= 1000; $i++) {

                            if (!empty($xml->infNFe->det[$i]->prod->cProd)) {

                                $produto        = $xml->infNFe->det[$i]->prod->cProd;
                                $nm_produto     = $xml->infNFe->det[$i]->prod->xProd;
                                $nr_qtde        = $xml->infNFe->det[$i]->prod->qCom;
                                $nr_valor       = $xml->infNFe->det[$i]->prod->vProd;
                                $unidade        = $xml->infNFe->det[$i]->prod->uCom;
                                $nr_ean         = $xml->infNFe->det[$i]->prod->cEANTrib;
                                $semResultado = 0;

                                $fl_imp     = 'S';
                                $fl_status  = 'A';

                                if ($unidade == "KG") {

                                    $insert_prd = "INSERT INTO tb_nf_entrada_item ";
                                    $insert_prd .= "(cod_nf_entrada,cod_rec,cod_ag,produto,nm_produto,nr_peso_unit,vl_unit,ds_unid,nr_ean,fl_status,fl_imp) VALUES ";
                                    $insert_prd .= "(:cod_nf_entrada,:cod_rec,:cod_ag,:produto,:nm_produto,:nr_peso_unit,:vl_unit,:ds_unid,:nr_ean,:fl_status,:fl_imp)";
    
                                    $result_prd = $conexao->prepare($insert_prd);
                                    $result_prd->bindParam(':cod_nf_entrada', $nova_nf, PDO::PARAM_STR);
                                    $result_prd->bindParam(':cod_rec', $cod_rec, PDO::PARAM_STR);
                                    $result_prd->bindParam(':cod_ag', $cod_rec, PDO::PARAM_STR);
                                    $result_prd->bindParam(':produto', $produto, PDO::PARAM_STR);
                                    $result_prd->bindParam(':nm_produto', $nm_produto, PDO::PARAM_STR);
                                    $result_prd->bindParam(':nr_peso_unit', $nr_qtde, PDO::PARAM_STR);
                                    $result_prd->bindParam(':vl_unit', $nr_valor, PDO::PARAM_STR);
                                    $result_prd->bindParam(':ds_unid', $unidade, PDO::PARAM_STR);
                                    $result_prd->bindParam(':nr_ean', $nr_ean, PDO::PARAM_STR);
                                    $result_prd->bindParam(':fl_status', $fl_status, PDO::PARAM_STR);
                                    $result_prd->bindParam(':fl_imp', $fl_imp, PDO::PARAM_STR);
                                    $result_prd->execute();

                                } else {

                                    $insert_prd = "INSERT INTO tb_nf_entrada_item ";
                                    $insert_prd .= "(cod_nf_entrada,cod_rec,cod_ag,produto,nm_produto,nr_qtde,vl_unit,ds_unid,nr_ean,fl_status,fl_imp) VALUES ";
                                    $insert_prd .= "(:cod_nf_entrada,:cod_rec,:cod_ag,:produto,:nm_produto,:nr_qtde,:vl_unit,:ds_unid,:nr_ean,:fl_status,:fl_imp)";
    
                                    $result_prd = $conexao->prepare($insert_prd);
                                    $result_prd->bindParam(':cod_nf_entrada', $nova_nf, PDO::PARAM_STR);
                                    $result_prd->bindParam(':cod_rec', $cod_rec, PDO::PARAM_STR);
                                    $result_prd->bindParam(':cod_ag', $cod_rec, PDO::PARAM_STR);
                                    $result_prd->bindParam(':produto', $produto, PDO::PARAM_STR);
                                    $result_prd->bindParam(':nm_produto', $nm_produto, PDO::PARAM_STR);
                                    $result_prd->bindParam(':nr_qtde', $nr_qtde, PDO::PARAM_STR);
                                    $result_prd->bindParam(':vl_unit', $nr_valor, PDO::PARAM_STR);
                                    $result_prd->bindParam(':ds_unid', $unidade, PDO::PARAM_STR);
                                    $result_prd->bindParam(':nr_ean', $nr_ean, PDO::PARAM_STR);
                                    $result_prd->bindParam(':fl_status', $fl_status, PDO::PARAM_STR);
                                    $result_prd->bindParam(':fl_imp', $fl_imp, PDO::PARAM_STR);
                                    $result_prd->execute();

                                }
                            
                            } else {

                                $semResultado++;

                            }

                            if ($semResultado >= 1000) {

                                break;

                            }
                            
                        }

                        $sql_nfe = "select nr_peso_ent, qtd_vol_ent ";
                        $sql_nfe .= "from tb_nf_entrada ";
                        $sql_nfe .= "where cod_nf_entrada = ?";
                        $stm_nfe = $conexao->prepare($sql_nfe);
                        $stm_nfe->bindValue(1, $nova_nf);
                        $stm_nfe->execute();
                        $count_nfe = $stm_nfe->rowCount();
                        
                        if ($count_nfe > 0) {

                            $row_nfe = $stm_nfe->fetch(PDO::FETCH_ASSOC);
    
                            $nr_peso    = $row_nfe['nr_peso_ent'];
                            $nr_volume  = $row_nfe['qtd_vol_ent'];

                            if ($nr_peso == 0 && $nr_volume == 0) {

                                $sql_pkg = "select sum(nr_peso_unit) as total ";
                                $sql_pkg .= "from tb_nf_entrada_item ";
                                $sql_pkg .= "where cod_nf_entrada = ?";
                                $stm_pkg = $conexao->prepare($sql_pkg);
                                $stm_pkg->bindValue(1, $nova_nf);
                                $stm_pkg->execute();
                                $count_pkg = $stm_pkg->rowCount();
                                
                                if ($count_pkg > 0) {

                                    $row_pkg = $stm_pkg->fetch(PDO::FETCH_ASSOC);
            
                                    $novo_peso    = $row_nfe['total'];

                                    $upd_prd = "UPDATE tb_nf_entrada set nr_peso_ent = ?, qtd_vol_ent = ? where cod_nf_entradad = ?";
                                    $res_upd = $conexao->prepare($upd_prd);

                                    $res_upd->bindParam(1, $novo_peso);
                                    $res_upd->bindParam(2, $novo_peso);
                                    $res_upd->bindParam(3, $nova_nf);
                                    $res_upd->execute();
                                
                                }

                            }

                            echo '<hr>';
                            echo 'Nota fiscal importada com sucesso.';
                            echo '<strong>NF:</strong> ' . $xml->infNFe->ide->nNF . '<br>';
                            /*echo '<strong>Serie:</strong> ' . $xml->infNFe->ide->serie . '<br>';
                            echo '<strong>Cfop:</strong> ' . $xml->infNFe->det->prod->CFOP . '<br>';
                            echo '<strong>dtEmissão:</strong> ' . $xml->infNFe->ide->dhEmi . '<br>';
                            echo '<strong>natOp:</strong> ' . $xml->infNFe->ide->natOp . '<br>';
                            echo '<strong>Emitente:</strong> ' . $xml->infNFe->emit->xNome . '<br>';
                            echo '<strong>Cnpj:</strong> ' . $xml->infNFe->emit->CNPJ . '<br>';
                            echo '<strong>IE:</strong> ' . $xml->infNFe->emit->IE . '<br>';
                            echo '<strong>Endereço:</strong> ' . $xml->infNFe->emit->enderEmit->xLgr . '<br>';
                            echo '<strong>Numero:</strong> ' . $xml->infNFe->emit->enderEmit->nro . '<br>';
                            echo '<strong>Bairro:</strong> ' . $xml->infNFe->emit->enderEmit->xBairro . '<br>';
                            echo '<strong>Cidade:</strong> ' . $xml->infNFe->emit->enderEmit->xMun . '<br>';
                            echo '<strong>UF:</strong> ' . $xml->infNFe->emit->enderEmit->UF . '<br>';
                            echo '<strong>Código Município de origem:</strong> ' . $xml->infNFe->emit->enderEmit->cMun . '<br>';
                            echo '<strong>CEP:</strong> ' . $xml->infNFe->emit->enderEmit->CEP . '<br>';
                            echo '<strong>Destinatário:</strong> ' . $xml->infNFe->dest->xNome . '<br>';
                            echo '<strong>Cnpj:</strong> ' . $xml->infNFe->dest->CNPJ . '<br>';
                            echo '<strong>IE:</strong> ' . $xml->infNFe->dest->IE . '<br>';
                            echo '<strong>Endereço:</strong> ' . $xml->infNFe->dest->enderDest->xLgr . '<br>';
                            echo '<strong>Numero:</strong> ' . $xml->infNFe->dest->enderDest->nro . '<br>';
                            echo '<strong>Bairro:</strong> ' . $xml->infNFe->dest->enderDest->xBairro . '<br>';
                            echo '<strong>Cidade:</strong> ' . $xml->infNFe->dest->enderDest->xMun . '<br>';
                            echo '<strong>UF:</strong> ' . $xml->infNFe->dest->enderDest->UF . '<br>';
                            echo '<strong>Código Município de destino:</strong> ' . $xml->infNFe->dest->enderDest->cMun . '<br>';
                            echo '<strong>CEP:</strong> ' . $xml->infNFe->dest->enderDest->CEP . '<br>';
                            echo '<strong>Peso:</strong> ' . $xml->infNFe->transp->vol->pesoB . '<br>';
                            echo '<strong>Vmercadoria:</strong> ' . $xml->infNFe->total->ICMSTot->vNF . '<br>';
                            echo '<strong>Volumes:</strong> ' . $xml->infNFe->transp->vol->qVol . '<br>';
                            echo '<strong>Chave:</strong> ' . $nfe_chave . '<br>';*/
                        } else {

                            echo 'Erro na inclusão de notas fiscais.';

                        }

                        $importado = 'xml/importados/' . $nome;
                        copy($origem, $importado);

                        require '../../PHPMailer-master/PHPMailerAutoload.php';
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Host = "smtp.hostinger.com.br";
                        $mail->Port = 587;
                        $mail->SMTPAutoTLS = true;
                        $mail->SMTPAuth = true;
                        $mail->Username = 'agendamento3c@argussistemas.com.br';
                        $mail->Password = 'ag3c2019#';

                        $mail->From = "agendamento3c@argussistemas.com.br";
                        $mail->FromName = "Agendamento de entregas 3C EDP";

                        $mail->AddAddress($email_copia, 'NFe EDP SAP');
                        $mail->AddCC($email_copia2, 'Controle');
                        $mail->IsHTML(true);
                        $mail->CharSet = 'UTF-8';
                        $mail->Subject = "ARGUS - Agendamento de entregas 3C EDP";
                        $mail->Body = "Arquivo XML de Nota Fiscal No. <b>" . $nr_nf_formulario . "</b> emitida pelo fornecedor <b>" . $nm_cliente . "</b>!";
                        //$mail->AltBody = "Este é o corpo da mensagem de teste, somente Texto! \r\n :)";

                        $mail->AddAttachment($importado);

                        $enviado = $mail->Send();

                        $mail->ClearAllRecipients();
                        $mail->ClearAttachments();

                        if ($enviado) {
                            $array_parte = array(
                                'info'     => "0",
                            );
                            //echo json_encode($array_parte, JSON_PRETTY_PRINT);
                            echo "E-mail enviado com sucesso!<br />" . $email_copia;
                        } else {
                            $array_parte = array(
                                'info'     => "1",
                            );
                            echo json_encode($array_parte, JSON_PRETTY_PRINT);
                        }

                        unlink($origem);
                    }
                }

            } else {

                echo "Erro ao realizar upload";

            }
        }
    }
}