<script charset="utf-8" src="http://code.jquery.com/jquery-1.7b1.js"></script>
// <script type="text/javascript">
//     $(document).ready(function(){
//         $("#listeFilm tr.toggleable" ).hide();
//         $("#listeFilm .tableToggleButton" ).click(function(){
//             $(this).parent().parent().next('tr').slideToggle('slow');
//         });
//     });
// </script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#listeFilm tr.toggleable" ).hide();
        $("#listeFilm .tableToggleButton" ).click(function(){
            $(this).parent().parent().next('tr').slideToggle('slow');
        });
    });
 </script>
<br />




<table border="1" class="listeFilm" id="listeFilm">
    <tr>
        <td><div class="tableToggleButton">ligne du film</div></td>
    </tr>
    <tr class="toggleable">
        <td>synopsis</td>
    </tr>  







    <tr>
        <td><div class="tableToggleButton">ligne du film2</div></td>
    </tr>
    <tr class="toggleable">
        <td>synopsis2</td>
    </tr>
    <tr>
        <td><div class="tableToggleButton">ligne du film3</div></td>
    </tr>
    <tr class="toggleable">
        <td>synopsis3</td>
    </tr>
</table>