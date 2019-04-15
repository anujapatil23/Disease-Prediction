<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
              crossorigin="anonymous">
        
         <style>
            .range {
                display: table;
                position: relative;
                height: 25px;
                margin-top: 20px;
                background-color: rgb(245, 245, 245);
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
                box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
                cursor: pointer;
            }

            .range input[type="range"] {
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                -ms-appearance: none !important;
                -o-appearance: none !important;
                appearance: none !important;

                display: table-cell;
                width: 100%;
                background-color: transparent;
                height: 25px;
                cursor: pointer;
            }
            .range input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                -ms-appearance: none !important;
                -o-appearance: none !important;
                appearance: none !important;

                width: 11px;
                height: 25px;
                color: rgb(255, 255, 255);
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: 0px;
                background-color: rgb(153, 153, 153);
            }

            .range input[type="range"]::-moz-slider-thumb {
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                -ms-appearance: none !important;
                -o-appearance: none !important;
                appearance: none !important;

                width: 11px;
                height: 25px;
                color: rgb(255, 255, 255);
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: 0px;
                background-color: rgb(153, 153, 153);
            }

            .range output {
                display: table-cell;
                padding: 3px 5px 2px;
                min-width: 40px;
                color: rgb(255, 255, 255);
                background-color: rgb(153, 153, 153);
                text-align: center;
                text-decoration: none;
                border-radius: 4px;
                border-bottom-left-radius: 0;
                border-top-left-radius: 0;
                width: 1%;
                white-space: nowrap;
                vertical-align: middle;

                -webkit-transition: all 0.5s ease;
                -moz-transition: all 0.5s ease;
                -o-transition: all 0.5s ease;
                -ms-transition: all 0.5s ease;
                transition: all 0.5s ease;

                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: -moz-none;
                -o-user-select: none;
                user-select: none;
            }
            .range input[type="range"] {
                outline: none;
            }

            .range.range-primary input[type="range"]::-webkit-slider-thumb {
                background-color: rgb(66, 139, 202);
            }
            .range.range-primary input[type="range"]::-moz-slider-thumb {
                background-color: rgb(66, 139, 202);
            }
            .range.range-primary output {
                background-color: rgb(66, 139, 202);
            }
            .range.range-primary input[type="range"] {
                outline-color: rgb(66, 139, 202);
            }

            .range.range-success input[type="range"]::-webkit-slider-thumb {
                background-color: rgb(92, 184, 92);
            }
            .range.range-success input[type="range"]::-moz-slider-thumb {
                background-color: rgb(92, 184, 92);
            }
            .range.range-success output {
                background-color: rgb(92, 184, 92);
            }
            .range.range-success input[type="range"] {
                outline-color: rgb(92, 184, 92);
            }

            .range.range-info input[type="range"]::-webkit-slider-thumb {
                background-color: rgb(91, 192, 222);
            }
            .range.range-info input[type="range"]::-moz-slider-thumb {
                background-color: rgb(91, 192, 222);
            }
            .range.range-info output {
                background-color: rgb(91, 192, 222);
            }
            .range.range-info input[type="range"] {
                outline-color: rgb(91, 192, 222);
            }

            .range.range-warning input[type="range"]::-webkit-slider-thumb {
                background-color: rgb(240, 173, 78);
            }
            .range.range-warning input[type="range"]::-moz-slider-thumb {
                background-color: rgb(240, 173, 78);
            }
            .range.range-warning output {
                background-color: rgb(240, 173, 78);
            }
            .range.range-warning input[type="range"] {
                outline-color: rgb(240, 173, 78);
            }

            .range.range-danger input[type="range"]::-webkit-slider-thumb {
                background-color: rgb(217, 83, 79);
            }
            .range.range-danger input[type="range"]::-moz-slider-thumb {
                background-color: rgb(217, 83, 79);
            }
            .range.range-danger output {
                background-color: rgb(217, 83, 79);
            }
            .range.range-danger input[type="range"] {
                outline-color: rgb(217, 83, 79);
            }
        </style>
    </head>
    <body>
   <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
				 
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="navbar-toggler-icon"></span>
				</button> 
<!--                         <a class="navbar-brand" href="#">About</a>-->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="navbar-nav">
						<li class="nav-item active">
                                                    <a class="nav-link" href="Registration.php">Add Pateint <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
                                                    <a class="nav-link" href="Analysis.php">Analysis</a>
						</li>
						
					</ul>
					
					
				</div>
			</nav>
       <div class="card">
	<div class="row">
		<div class="col-md-12">
                   
                    <form action="Registration.php" method="post">
				<div class="form-group">
					 
					<label for="exampleInputEmail1">
						Patient Name:
					</label>
                                    <input type="text" class="form-control" name="name" />
				</div>
				<div class="form-group">
					 
					<label for="exampleInputPassword1">
						Patient Id:
					</label>
                                    <input type="number" class="form-control" name="id" />
				</div>
                            <div class="form-group">
					 
					<label for="exampleInputPassword1">
						Height:
					</label>
                                    <input type="number" class="form-control" name="height" />
				</div>
                            <div class="form-group">
					 
                                <label for="exampleInputPassword1" >
						Weight:
					</label>
                                    <input type="number" class="form-control" name="weight" />
				</div>
				
                            <h3>Symptoms Data </h3><br>
                            
                            <div class="row" >
				<div class="col-md-12">
			<table class="table table-bordered table-hover">
                            <col width="80">
                            <col width="530">
                            <col width="10">
                            
                           
				<thead style="alignment-text: central">
					<tr>
						<th>
							&nbsp;&nbsp;&nbsp;&nbsp;Id
						</th>
                                                <th >
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Symptoms
						</th>
                                                <th>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes/No
						</th>
						
						<th>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Severity
						</th>
					</tr>
				</thead>
				<tbody>
					
                                     <?php
                include_once 'connection.php';
                $symptomQry="SELECT * FROM ml_symptoms";
                $result=  mysqli_query($con, $symptomQry);
                $symtomsList=mysqli_fetch_all($result,MYSQLI_ASSOC);
                foreach ($symtomsList as $key => $value) {
                    echo '<tr>';
                    echo '<td>'.$value['id'].'</td>';
                    echo '<td>'.$value['title'].'</td>';
                    echo '<td><div class="range">';
                   
                     echo '<input type="range" name="range0[]" min="0" max="1" step="1" value="0" onchange="range0_'.$value['id'].'.value = value">';
                    echo '<output id="range0_'.$value['id'].'">0</output>';
                    echo '</div></td>';
                    echo '<td><div class="range">';
                    echo '<input type="range" name="range[]" min="0.00" max="1.00" step="0.05" value="0.00" onchange="range_'.$value['id'].'.value = value">';
                    echo '<output id="range_'.$value['id'].'">0.00</output>';
                    echo '</div></td>'; 
                    echo '</tr>';

                }
                
                ?>       
            </tr>
                                    
                                    
				</tbody>
			</table>
		</div>
			</div>
                            <h3>Lab Data </h3><br>
                            <div class="row" >
				<div class="col-md-12">
			<table class="table table-bordered table-hover">
                            <col width="100">
                            <col width="600">
                            
                            
                           
				<thead style="alignment-text: central">
					<tr>
						<th>
							&nbsp;&nbsp;&nbsp;&nbsp;Id
						</th>
                                                <th >
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lab Tests
						</th>
						<th>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes/No
						</th>
                                                <th>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;severity
						</th>
                                                <th>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lab Report Values
						</th>
                                               
						
					</tr>
				</thead>
				<tbody>
					 <?php
                include_once 'connection.php';
                $labQry="SELECT * FROM ml_lab_test";
                $result=  mysqli_query($con, $labQry);
                $labList=mysqli_fetch_all($result,MYSQLI_ASSOC);
                foreach ($labList as $key => $value) {
                    echo '<tr>';
                    echo '<td>'.$value['id'].'</td>';
                    echo '<td>'.$value['title'].'</td>';
                    echo '<td><div class="range">';
                   
                     echo '<input type="range" name="range1[]" min="0" max="1" step="1" value="0" onchange="range1_'.$value['id'].'.value = value">';
                    echo '<output id="range1_'.$value['id'].'">0</output>';
                    echo '</div></td>';
                   
                    echo '<td><div class="range">';
                    echo '<input type="range" name="range4[]" min="0.00" max="1.00" step="0.05" value="0.00" onchange="range4_'.$value['id'].'.value = value">';
                    echo '<output id="range4_'.$value['id'].'">0.00</output>';
                    echo '</div></td>'; 
                    echo '<td><div>';
                     echo '<input type="number" name="result[]" value="0">';
                    echo '</div></td>';
                    echo '</tr>';

                }
                
                ?>
                            
                    </tr>
				</tbody>
			</table>
		</div>
			</div>
                            
                            <h3>History Data </h3><br>
                            <div class="row" >
				<div class="col-md-12">
			<table class="table table-bordered table-hover">
                            <col width="100">
                            <col width="600">
                            
                            
                           
				<thead style="alignment-text: central">
					<tr>
						<th>
							&nbsp;&nbsp;&nbsp;&nbsp;Id
						</th>
                                                <th >
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;History
						</th>
						<th>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yes/No
						</th>
                                                <th>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Severity
						</th>
                                               
						
					</tr>
				</thead>
				<tbody>
					 <?php
                include_once 'connection.php';
                $labQry="SELECT * FROM ml_history";
                $result=  mysqli_query($con, $labQry);
                $historylist=mysqli_fetch_all($result,MYSQLI_ASSOC);
                foreach ($historylist as $key => $value) {
                    echo '<tr>';
                    echo '<td>'.$value['id'].'</td>';
                    echo '<td>'.$value['title'].'</td>';
                    echo '<td><div class="range">';
                   
                     echo '<input type="range" name="range2[]" min="0" max="1" step="1" value="0" onchange="range2_'.$value['id'].'.value = value">';
                    echo '<output id="range2_'.$value['id'].'">0</output>';
                    echo '</div></td>';
                   
                    echo '<td><div class="range">';
                    echo '<input type="range" name="range3[]" min="0.00" max="1.00" step="0.05" value="0.00" onchange="range3_'.$value['id'].'.value = value">';
                    echo '<output id="range3_'.$value['id'].'">0.00</output>';
                    echo '</div></td>';
                    
                    echo '</tr>';

                }
                
                ?>
                    
                        
                        
                        
                    
                    
                
                            
                    </tr>
				</tbody>
			</table>
		</div>
			</div>
                            <input type="submit" class="btn-primary" name="submit" value="Save">
			</form>
		</div>
	</div>
    </div>
       
</div> 
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    
 </body>   
</html>

<?php
if(isset($_POST['submit'])){
include_once 'connection.php';

 
  //print_r($_POST);
  

    $name=$_POST['name'];
    $pid=$_POST['id'];
    $height=$_POST['height'];
    //$height=$height/3.281;
    $height=$height/100;
    $weight=$_POST['weight'];
    $range=$_POST['range'];
    $lab=$_POST['range1'];
    $symps=$_POST['range0'];
    $his=$_POST['range2'];
    $his_valu=$_POST['range3'];
    $lab_pro=$_POST['range4'];
    $result=$_POST['result'];
     $bmi=$weight / ($height * $height);    

if($bmi<18.5)
{
   $bmi_status="Underweight";
}
elseif ($bmi>=18.5 && $bmi<24.9) {
 $bmi_status="Normal";
}
elseif ($bmi>=25.0 && $bmi<29.9) {
$bmi_status="Overweight";
}
elseif ($bmi>=30.0 && $bmi<34.9) {
 $bmi_status="Obeisity 1";
}
elseif ($bmi>=35 && $bmi<39.9) {
$bmi_status="Obesity 2"; 

}
elseif ($bmi>=40.0 ) {
 $bmi_status="Extreme Obesity";
}
       
    $symptoms=  implode(",", $range);
    $symptoms_l=  implode(",", $symps);
    $history=  implode(",", $his);
    $history_l=  implode(",", $his_valu);
    $lab_test=  implode(",", $lab);
    $lab_probabi=  implode(",", $lab_pro);
    $value=  implode(",", $result);
    echo $lab_test."<br>";
      echo $value."<br>";
      if($con)
      {
          echo "hello";
      }
     $query="insert into ml_patiet_data(`patient_id`,`patient_name`,`height`,`weight`,`symptoms_value`, `lab_list`, `lab_value`,`bmi`,`symptoms_list`,`history`,`historys_prob`,`lab_prob`,`bmi_status`)values('$pid','$name','$height','$weight','$symptoms','$lab_test','$value','$bmi','$symptoms_l','$history','$history_l','$lab_probabi','$bmi_status')";
     print_r($query);
$result1=  mysqli_query($con, $query);
if ($result>0)
{
}

}
?>