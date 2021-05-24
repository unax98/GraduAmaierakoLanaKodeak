<?php  
 require('db_konektatu.php'); 
 $query ="SELECT * FROM korridorea ORDER BY id DESC";
 $query1 ="SELECT * FROM berogailua ORDER BY id DESC";
 $query2 ="SELECT * FROM ikasgela ORDER BY id DESC";  
 $result = mysqli_query($conn, $query);
 $result1 = mysqli_query($conn, $query1);
 $result2 = mysqli_query($conn, $query2); 
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Datu taula</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

      </head>  
      <body>  
           <h2 style = "text-align: center; padding: 20px; background-color: #333; color: #fff;">DATU TAULAK </h2>
           <div class = "container" style = "margin-top: 40px; padding: 0px;">
           <h3 class="text-center">KORRIDOREKO ARGIEN DATU TAULA</h3>
           <br /><br />  
           <div class="container">  
                 
                <div class="table-responsive">  
                     <table id="korridorea" class="table table-striped table-bordered">  
                          <thead>  
                               <tr> 
                                    <td>Zenb.</td>
                                    <td>LdrBalioa</td>  
                                    <td>Tentsioa</td>  
                                    <td>Data</td> 
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["id"].'</td>
                                    <td>'.$row["ldrBalioa"].'</td>  
                                    <td>'.$row["tentsioa"].'</td>  
                                    <td>'.$row["data"].'</td> 
                               </tr>  
                               ';  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>
           <div class = "container" style = "margin-top: 40px; padding: 0px;">
           <h3 class="text-center">SOLAIRUKO TENPERATURA ETA HEZETASUNA</h3>
           <br /><br />  
           <div class="container">  
                 
                <div class="table-responsive">  
                     <table id="berogailua" class="table table-striped table-bordered">  
                          <thead>  
                               <tr> 
                                    <td>Zenb.</td>
                                    <td>Tenperatura</td>  
                                    <td>Hezetasuna</td>
                                    <td>Balbula</td>
                                    <td>Data</td> 
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result1))  
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["id"].'</td>
                                    <td>'.$row["tenperatura"].'</td>  
                                    <td>'.$row["hezetasuna"].'</td>
                                    <td>'.$row["balbula"].'</td>
                                    <td>'.$row["data"].'</td> 
                               </tr>  
                               ';  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div> 
           <div class = "container" style = "margin-top: 40px; padding: 0px;">
           <h3 class="text-center">IKASGELAKO ARGIEN EGOERA</h3>
           <br /><br />  
           <div class="container">  
                 
                <div class="table-responsive">  
                     <table id="ikasgela" class="table table-striped table-bordered">  
                          <thead>  
                               <tr> 
                                    <td>Zenb.</td>
                                    <td>Egoera (1 = mugimendua dago / 0 = ez dago mugimendurik)</td>  
                                    <td>Data</td> 
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result2))  
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["id"].'</td>
                                    <td>'.$row["argia"].'</td>  
                                    <td>'.$row["data"].'</td> 
                               </tr>  
                               ';  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#korridorea').DataTable();
      $('#berogailua').DataTable();
      $('#ikasgela').DataTable(); 
 });  
 </script>  
 <button class = "btn btn-primary btn-sm"><a href = "grafikoak.php" style = "text-decoration: none; color: #fff;"><i class="fas fa-chart-bar"></i> Emaitza Grafikoak</a></button>
