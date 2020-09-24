<?php

$nav_selected = "MOVIES";
$left_buttons = "YES";
$left_selected = "RELEASES";

include("./nav.php");
global $db;

?>

<br><br>
<div class="container-fluid">
    <?php
        if(isset($_GET['MovieDeleted'])){
            if($_GET["MovieDeleted"] == "Success"){
                echo '<br><h3>Success! Your movie has been deleted!</h3>';
            }
        }
    ?>


<div class="right-content">
  <div class="container">

      <table id="info" cellpadding="0" cellspacing="0" 
          class="datatable table table-striped table-bordered datatable-style table-hover"
          width="100%" style="width: 100px;">
            <thead>
              <tr id="table-first-row">
                      <th>Movie id</th>
                      <th>Movie Name (Original)</th>
                      <th>Movie Name (English)</th>
                      <th>Movie Year</th>
                      <th>Delete</th>

              </tr>
            </thead>

            <tfoot>
              <tr>
                      <th>Movie id</th>
                      <th>Movie Name (Original)</th>
                      <th>Movie Name (English)</th>
                      <th>Movie Year</th>
                      <th>Delete</th>
              </tr>
            </tfoot>
        <tbody>
<?php

$sql = "SELECT * FROM movies";
$image = "SELECT * FROM movies LEFT JOIN movie_media ON movies.movie_id = movie_media.movie_id WHERE movie_media.m_link_type = 'poster'";

$result = $db->query($sql);

              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo '<tr> 
                              <td><a href="movies_info.php?movie_id='.$row['movie_id'].'" ?><b>'.$row["movie_id"].'</b></td>
                              <td><a href="movies_info.php?movie_id='.$row['movie_id'].'" ?><b>'.$row["native_name"].'</b></td>
                              <td>'.$row["english_name"].'</td>
                              <td>'.$row["year_made"].'</td>
                              <td><a href="delete.php?delete='.$row['movie_id'].'" class = "btn btn-danger"; ?>Delete</td>
                          </tr>';

                  }//end while
              }//end if
              else {
                  echo "0 results";
              }//end else

               $result->close();
              ?>

            </tbody>
      </table>


      <script type="text/javascript" language="javascript">
  $(document).ready( function () {

      $('#info').DataTable( {
          dom: 'lfrtBip',
          buttons: [
              'copy', 'excel', 'csv', 'pdf'
          ] }
      );

      $('#info thead tr').clone(true).appendTo( '#info thead' );
      $('#info thead tr:eq(1) th').each( function (i) {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

          $( 'input', this ).on( 'keyup change', function () {
              if ( table.column(i).search() !== this.value ) {
                  table
                      .column(i)
                      .search( this.value )
                      .draw();
              }
          } );
      } );

      var table = $('#info').DataTable( {
          orderCellsTop: true,
          fixedHeader: true,
          retrieve: true
      } );

  } );

</script>



<style>
 tfoot {
   display: table-header-group;
 }
</style>

<?php include("./footer.php"); ?>
