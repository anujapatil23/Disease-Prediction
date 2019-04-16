<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    
    <title>Diagnosis System</title>
         
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<body>
        <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

                     <nav class="navbar navbar-expand-lg navbar-light bg-light">
				 
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="navbar-toggler-icon"></span>
				</button> 
<!--                         <a class="navbar-brand" href="#">About</a>-->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="navbar-nav">
						<li class="nav-item active">
                                                    <a class="nav-link" href="Registration.php">Registraion </a>
						</li>
						<li class="nav-item">
                                                    <a class="nav-link" href="Analysis.php">Analysis<span class="sr-only">(current)</span></a>
						</li>
						
					</ul>
					
					
				</div>
			</nav>
                    
                    <form action="dx_influence_graph.php" method="post">
				<div class="form-group">
					 
					<label for="exampleInputEmail1">
						Patient Id:
					</label>
                                    <input type="number" class="form-control" name="p_id" />
				</div>
                        <div class="form-group">
                            <input type="submit" class="btn-primary" name="probability" value="Analyze by probability">
                            
                        </div>
                         <div class="form-group">
                            <input type="submit" class="btn-primary" name="weight" value="Analyze by weight">
                            
                        </div>
                       
                         <div class="form-group">
                            <input type="submit" class="btn-primary" name="lab" value="Analyze by lab test">
                            
                        </div>
                         <div class="form-group">
                            <input type="submit" class="btn-primary" name="symptoms" value=" Analyze by symptoms">
                            
                        </div>
                         <div class="form-group">
                            <input type="submit" class="btn-primary" name="history" value="Analyze by history">
                            
                        </div>
                         <div class="form-group">
                            <input type="submit" class="btn-primary" name="mlp_sym" value="Analyze by neural network with symptoms">
                            
                        </div>
                         <div class="form-group">
                            <input type="submit" class="btn-primary" name="mlp_his" value="Analyze by neural network with history">
                            
                        </div>
                         <div class="form-group">
                            <input type="submit" class="btn-primary" name="mlp_lab" value="Analyze by neural network with lab ">
                            
                        </div>
                         <div class="form-group">
                            <input type="submit" class="btn-primary" name="mlp" value="Analyze by neural network ">
                            
                        </div>
                        
                    </form>
	
		</div>
	</div>
</div>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    
        
    </body>
</html>
