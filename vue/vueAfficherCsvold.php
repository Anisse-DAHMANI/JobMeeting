<?php
require_once 'util/utilitairePageHtml.php';

class VueAfficherCsv{



    public function afficherPlanning($tableCsv,$export,$titre){
        $util = new UtilitairePageHtml();
        echo $util->genereBandeauApresConnexion();
        echo "<div id='centeraffcsv'> <br>";
        echo '<br/><br> <a id="telechargeraffcsv" href=?export='.$export.'&telecharger=oui><b>Télecharger</b> </a>';
       echo "<br><br>";
        echo $titre;
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



</script>
<?php
    }

}
?>