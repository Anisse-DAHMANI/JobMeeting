<?php
require_once 'util/utilitairePageHtml.php';

class VueAfficherCsv{

    public function afficherPlanning($tableCsv,$export,$titre){
        $util = new UtilitairePageHtml();
        echo $util->genereBandeauApresConnexion();
        
        if($export == "Planning"){
        echo "<div id='centeraffcsv'> <br>";
        //echo '<br/><br> <a id="telechargeraffcsv" href=?export='.$export.'&telecharger=oui  "><b>Télecharger tous le planning</b>  </a> </div>';
        }
        echo "<div id='centeraffcsv'> <br>";
        echo "<br><br>";
        echo $titre;
        
        //echo '<br/><br> <a id="telechargeraffcsv" href=?export='.$export.'&telecharger=oui><b>Télecharger</b> </a>';
        echo "<table id='tabaffichecsv' border=1>";

        $first = false;
        $nbcolone=0;
        foreach ($tableCsv as $valueLigne) {
            if(!$first){
                echo '<thead><tr class="traffichecsv">';

                foreach($valueLigne as $value){
                    echo "<th class='thaffichecsv' onclick='monsort(".$nbcolone.")'>".$value."</th>";
                    $nbcolone++;
                }
                echo"</tr></thead><tbody>";

                $first = !$first;
            } else {


                echo '<tr class="traffichecsv">';

                foreach ($valueLigne as $value) {
                    if (is_numeric($value)) {
                        echo "<td class='tdintaffichecsv'>" . $value . "</td>";
                    } else {
                        echo "<td class='tdotheraffichecsv'>" . $value . "</td>";
                    }

                }
                echo "</tr>";

            }
        }
        echo "</tbody></table></div>";
        echo "<br><br>";
        ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css ">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">


    <script src="https://code.jquery.com/jquery-3.3.1.js "></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js "></script>
    <script>


    let unsurdeux = false;

    function monsort(col) {
        if (unsurdeux==true) {
            sortTable("tabaffichecsv",col,DESC);
        } else {
            sortTable("tabaffichecsv",col,ASC);
        }
        unsurdeux = !unsurdeux;
    }
    function lignecolor(){
        let lignsurdeux =$('tr:nth-child(2n) td');
        lignsurdeux.css("background-color","#f2f2f2");
        $('tr:nth-child(2n+1) td').css("background-color","lightgrey");
    }

    function sortTable(tid, col, ord){
        mybody=document.getElementById(tid).getElementsByTagName('tbody')[0];
        lines=mybody.getElementsByTagName('tr');
        var sorter=new Array();
        sorter.length=0;
        var i=-1;
        while(lines[++i]){

            if (/^\+?\d+$/.test(lines[i].getElementsByTagName('td')[col].innerHTML)){
                sorter.push([lines[i],parseInt(lines[i].getElementsByTagName('td')[col].innerHTML)]);
            } else {

                sorter.push([lines[i],(lines[i].getElementsByTagName('td')[col].innerHTML)]);

            }

        }
        sorter.sort(ord);
        j=-1;
        while(sorter[++j]){
            mybody.appendChild(sorter[j][0])
        }
        lignecolor();
    }

    function DESC(a,b)
    {
        a=a[1]
        b=b[1]
        if(a > b)
            return -1
        if(a < b)
            return 1
        return 0
    }

    function ASC(a,b){
        a=a[1];
        b=b[1];
        if(a > b)
            return 1;
        if(a < b)
            return -1;
        return 0;
    }
    $(document).ready( function(){
        $('#tabaffichecsv').DataTable({
            "paging":false,
	 		"bSort": false,
            "info": false,
            dom: 'Bfrtip',
            buttons: ['pdf','copy','csv','excel','print'] 
        });

    });

</script>
<?php
    }

    public function afficherTableau($tableCsv,$export,$titre){
        ?>
        <?php
        echo "<div id='centeraffcsv'> <br>";
        echo "<br><br>";
        echo $titre;
        
        echo '<br/><br> <a id="telechargeraffcsv" href=?export='.$export.'&telecharger=oui><b>Télecharger</b> </a>';
        echo "<table id='tabaffichecsv' border=1>";

        $first = false;
        $nbcolone=0;
        foreach ($tableCsv as $valueLigne) {
            if(!$first){
                echo '<thead><tr class="traffichecsv">';

                foreach($valueLigne as $value){
                    echo "<th class='thaffichecsv' >".$value."</th>";
                    $nbcolone++;
                }
                echo"</tr></thead><tbody>";

                $first = !$first;
            } else {


                echo '<tr class="traffichecsv">';

                foreach ($valueLigne as $value) {
                    if (is_numeric($value)) {
                        echo "<td class='tdintaffichecsv'>" . $value . "</td>";
                    } else {
                        echo "<td class='tdotheraffichecsv'>" . $value . "</td>";
                    }

                }
                echo "</tr>";

            }
        }
        echo "</tbody></table></div>";
        echo "<br><br>";

        ?>
<script>

    let unsurdeux = false;

    function monsort(col) {
        if (unsurdeux==true) {
            sortTable("tabaffichecsv",col,DESC);
        } else {
            sortTable("tabaffichecsv",col,ASC);
        }
        unsurdeux = !unsurdeux;
    }
    function lignecolor(){
        let lignsurdeux =$('tr:nth-child(2n) td');
        lignsurdeux.css("background-color","#f2f2f2");
        $('tr:nth-child(2n+1) td').css("background-color","lightgrey");
    }

    function sortTable(tid, col, ord){
        mybody=document.getElementById(tid).getElementsByTagName('tbody')[0];
        lines=mybody.getElementsByTagName('tr');
        var sorter=new Array();
        sorter.length=0;
        var i=-1;
        while(lines[++i]){

            if (/^\+?\d+$/.test(lines[i].getElementsByTagName('td')[col].innerHTML)){
                sorter.push([lines[i],parseInt(lines[i].getElementsByTagName('td')[col].innerHTML)]);
            } else {

                sorter.push([lines[i],(lines[i].getElementsByTagName('td')[col].innerHTML)]);

            }

        }
        sorter.sort(ord);
        j=-1;
        while(sorter[++j]){
            mybody.appendChild(sorter[j][0])
        }
        lignecolor();
    }

    function DESC(a,b)
    {
        a=a[1]
        b=b[1]
        if(a > b)
            return -1
        if(a < b)
            return 1
        return 0
    }

    function ASC(a,b){
        a=a[1];
        b=b[1];
        if(a > b)
            return 1;
        if(a < b)
            return -1;
        return 0;
    }
        
    function getBase64Image(img) {
  var canvas = document.createElement("canvas");
  canvas.width = img.width;
  canvas.height = img.height;
  var ctx = canvas.getContext("2d");
  ctx.drawImage(img, 0, 0);
  var dataURL = canvas.toDataURL("image/png");
  return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}

</script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css ">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">


    <script src="https://code.jquery.com/jquery-3.3.1.js "></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js "></script>
    <script>

    $(document).ready( function(){
        $('#tabaffichecsv').DataTable({
            "paging":false,
	 		"bSort": false,
            "info": false,
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','print',            {
                extend: 'pdfHtml5',
                customize: function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:vue/img/bandeau-RAlt-2018.PNG;base64,'+getBase64Image(document.querySelector("img"))
                    } );
                }
            }] 
        });

    });

</script>
<?php
    }

    public function afficherTableauTer($tableCsv,$export,$titre,$form){
        ?>
        <!--<script type="text/javascript" src="vue/js/AutreDataTable.js"></script>-->
        <?php
        echo "<div id='centeraffcsv'> <br>";
        echo '<br/><br> <a id="telechargeraffcsv" href=?export='.$export.'&telecharger=oui&format=pdf&tout=oui><b>Tout télecharger en pdf</b> </a>';
        echo '<br/><br> <a id="telechargeraffcsv" href=?export='.$export.'&telecharger=oui&format=csv&tout=oui><b>Tout télecharger en csv</b> </a>';
        echo "<br><br>";
        echo $titre;
        echo '<br/><br> <a id="telechargeraffcsv" href=?export='.$export.'&telecharger=oui&format=csv&idEnt='.$form->getId().'&nomEnt='.str_replace(' ', '_', $form->getNomEnt()).'><b>Télecharger en csv</b> </a>';
        echo '<br/><br> <a id="telechargeraffpdf" href=?export='.$export.'&telecharger=oui&format=pdf&idEnt='.$form->getId().'&nomEnt='.str_replace(' ', '_', $form->getNomEnt()).'><b>Télecharger en pdf</b> </a>';
        echo "<table id='tabaffichecsv' border=1>";

        $first = false;
        $nbcolone=0;
        foreach ($tableCsv as $valueLigne) {
            if(!$first){
                echo '<thead><tr class="traffichecsv">';

                foreach($valueLigne as $value){
                    echo "<th class='thaffichecsv' >".$value."</th>";
                    $nbcolone++;
                }
                echo"</tr></thead><tbody>";

                $first = !$first;
            } else {


                echo '<tr class="traffichecsv">';

                foreach ($valueLigne as $value) {
                    if (is_numeric($value)) {
                        echo "<td class='tdintaffichecsv'>" . $value . "</td>";
                    } else {
                        echo "<td class='tdotheraffichecsv'>" . $value . "</td>";
                    }

                }
                echo "</tr>";

            }
        }
        echo "</tbody></table></div>";
        echo "<br><br>";

        ?>
<script>

    let unsurdeux = false;

    function monsort(col) {
        if (unsurdeux==true) {
            sortTable("tabaffichecsv",col,DESC);
        } else {
            sortTable("tabaffichecsv",col,ASC);
        }
        unsurdeux = !unsurdeux;
    }
    function lignecolor(){
        let lignsurdeux =$('tr:nth-child(2n) td');
        lignsurdeux.css("background-color","#f2f2f2");
        $('tr:nth-child(2n+1) td').css("background-color","lightgrey");
    }

    function sortTable(tid, col, ord){
        mybody=document.getElementById(tid).getElementsByTagName('tbody')[0];
        lines=mybody.getElementsByTagName('tr');
        var sorter=new Array();
        sorter.length=0;
        var i=-1;
        while(lines[++i]){

            if (/^\+?\d+$/.test(lines[i].getElementsByTagName('td')[col].innerHTML)){
                sorter.push([lines[i],parseInt(lines[i].getElementsByTagName('td')[col].innerHTML)]);
            } else {

                sorter.push([lines[i],(lines[i].getElementsByTagName('td')[col].innerHTML)]);

            }

        }
        sorter.sort(ord);
        j=-1;
        while(sorter[++j]){
            mybody.appendChild(sorter[j][0])
        }
        lignecolor();
    }

    function DESC(a,b)
    {
        a=a[1]
        b=b[1]
        if(a > b)
            return -1
        if(a < b)
            return 1
        return 0
    }

    function ASC(a,b){
        a=a[1];
        b=b[1];
        if(a > b)
            return 1;
        if(a < b)
            return -1;
        return 0;
    }
        
    function getBase64Image(img) {
  var canvas = document.createElement("canvas");
  canvas.width = img.width;
  canvas.height = img.height;
  var ctx = canvas.getContext("2d");
  ctx.drawImage(img, 0, 0);
  var dataURL = canvas.toDataURL("image/png");
  return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}
</script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css ">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">


    <script src="https://code.jquery.com/jquery-3.3.1.js "></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js "></script>
    <!--<script>


    $(document).ready( function(){
    

        $('#tabaffichecsv').DataTable({
            "paging":false,
	 		"bSort": false,
            "info": false,
            dom: 'Bfrtip',
            buttons: ['copy','csv','excel','print',            {
                extend: 'pdfHtml5',
                customize: function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:vue/img/bandeau-RAlt-2018.PNG;base64,'+getBase64Image(document.querySelector("img"))
                    } );
                }
            }] 
        });

    });-->

</script>
<?php
    }

    public function afficherTableauBis($tableCsv,$export,$titre,$form){
       
        echo "<div id='centeraffcsv'> <br>";
        echo "<br><br>";
        echo $titre;
        
        echo '<br/><br> <a id="telechargeraffcsv" href=?export='.$export.'&telecharger=oui&format=csv&idEnt='.$form->getId().'&nomEnt='.str_replace(' ', '_', $form->getNomEnt()).'><b>Télecharger en csv</b> </a>';
        echo '<br/><br> <a id="telechargeraffpdf" href=?export='.$export.'&telecharger=oui&format=pdf&idEnt='.$form->getId().'&nomEnt='.str_replace(' ', '_', $form->getNomEnt()).'><b>Télecharger en pdf</b> </a>';
        echo "<table id='tabaffichecsv' border=1>";

        $first = false;
        $nbcolone=0;
        foreach ($tableCsv as $valueLigne) {
            if(!$first){
                echo '<thead><tr class="traffichecsv">';

                foreach($valueLigne as $value){
                    echo "<th class='thaffichecsv' >".$value."</th>";
                    $nbcolone++;
                }
                echo"</tr></thead><tbody>";

                $first = !$first;
            } else {


                echo '<tr class="traffichecsv">';

                foreach ($valueLigne as $value) {
                    if (is_numeric($value)) {
                        echo "<td class='tdintaffichecsv'>" . $value . "</td>";
                    } else {
                        echo "<td class='tdotheraffichecsv'>" . $value . "</td>";
                    }

                }
                echo "</tr>";

            }
        }
        echo "</tbody></table></div>";
        echo "<br><br>";

        ?>
<script>

    function monsort(col) {
        if (unsurdeux==true) {
            sortTable("tabaffichecsv",col,DESC);
        } else {
            sortTable("tabaffichecsv",col,ASC);
        }
        unsurdeux = !unsurdeux;
    }
    function lignecolor(){
        let lignsurdeux =$('tr:nth-child(2n) td');
        lignsurdeux.css("background-color","#f2f2f2");
        $('tr:nth-child(2n+1) td').css("background-color","lightgrey");
    }

    function sortTable(tid, col, ord){
        mybody=document.getElementById(tid).getElementsByTagName('tbody')[0];
        lines=mybody.getElementsByTagName('tr');
        var sorter=new Array();
        sorter.length=0;
        var i=-1;
        while(lines[++i]){

            if (/^\+?\d+$/.test(lines[i].getElementsByTagName('td')[col].innerHTML)){
                sorter.push([lines[i],parseInt(lines[i].getElementsByTagName('td')[col].innerHTML)]);
            } else {

                sorter.push([lines[i],(lines[i].getElementsByTagName('td')[col].innerHTML)]);

            }

        }
        sorter.sort(ord);
        j=-1;
        while(sorter[++j]){
            mybody.appendChild(sorter[j][0])
        }
        lignecolor();
    }

    function DESC(a,b)
    {
        a=a[1]
        b=b[1]
        if(a > b)
            return -1
        if(a < b)
            return 1
        return 0
    }

    function ASC(a,b){
        a=a[1];
        b=b[1];
        if(a > b)
            return 1;
        if(a < b)
            return -1;
        return 0;
    }

</script>
<?php
    }
}
?>