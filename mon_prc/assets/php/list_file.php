<?php

$id_rec = $_POST["cod_rec"];

$types = array( 'pdf' );

$table = "<table><tbody>";

if(is_dir('../pdf/'.$id_rec.'/')){

 if ( $handle = opendir('../pdf/'.$id_rec.'/') ) {

   while ( $entry = readdir( $handle ) ) {

     $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );

     if( in_array( $ext, $types ) ) {

       $table .= "<tr>
       <td><h3><strong>ARQUIVO:&nbsp&nbsp</strong></h3></td>
       <td><h3>".$entry."</h3></td>
       <td style='width:20px'></td>
       <td style='width:20px'><button type='button' class='btn btn-default btn-xs'><a href='assets/pdf/".$id_rec."/".$entry."' target='_blank'>ABRIR</a></button></td>
       <td style='width:20px'><button type='button' class='btn btn-danger btn-xs btnDelFile' id='btnDelFile' value='assets/pdf/".$id_rec."/".$entry."'>EXCLUIR</button></td>
       </tr>";

     }

   }

   closedir($handle);

 }else{

   $table .= "<tr>
   <td><h3><strong>ARQUIVO:&nbsp&nbsp</strong></h3></td>
   <td><h3><h3>NOTA FISCAL NÃO IMPORTADA</h3></h3></td>
   <td style='width:20px'></td>
   <td style='width:20px'></td>
   <td style='width:20px'></td>
   </tr>";

 } 
 
}else{

 $table .= "<tr>
 <td><h3><strong>ARQUIVO:&nbsp&nbsp</strong></h3></td>
 <td><h3><h3>NOTA FISCAL NÃO IMPORTADA</h3></h3></td>
 <td style='width:20px'></td>
 <td style='width:20px'></td>
 <td style='width:20px'></td>
 </tr>";

}    

$table .= "</tbody></table>";

echo $table;
?>