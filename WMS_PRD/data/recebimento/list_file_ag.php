 <?php
 $path = $_SERVER['DOCUMENT_ROOT'] . '/area_rest/data/recebimento_edp/pdf/';
 $pdf = '/area_rest/data/recebimento_edp/pdf/';
 
 $id_rec =$_POST["nf_rec"];

 $types = array( 'pdf' );

 $table = "<table><tbody>";

 if ( $handle = opendir($path.$id_rec.'/') ) {
  while ( $entry = readdir( $handle ) ) {
    $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
    if( in_array( $ext, $types ) ) 

      $table .= "<tr>
    <td><h3><strong>ARQUIVO:&nbsp&nbsp</strong></h3></td>
    <td><h3>".$entry."</h3></td>
    <td style='width:20px'></td>
    <td style='width:20px'><button type='button' class='btn btn-default btn-xs'><a href='".$pdf.$id_rec."/".$entry."' target='_blank'>ABRIR</a></button></td>
    <td style='width:20px'><button type='button' class='btn btn-danger btn-xs btnDelFile' id='btnDelFile' value='pdf/".$id_rec."/".$entry."'>EXCLUIR</button></td>
    </tr>";
  }

  $table .= "</tbody></table>";

  echo $table;

  closedir($handle);
}    
?>