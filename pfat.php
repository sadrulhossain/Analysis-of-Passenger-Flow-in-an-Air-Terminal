<?php 

	//all necessary variables defined
	$total_simulation_timeh = $total_simulation_time = $random_arrival_time = $probability = "";
	$arrival_time = $rand_arr = $prob_arr = $c_prob_arr = "";
	$service_time_1 = $service_time_2 = $prob_svr = $c_prob_svr = "";
	$tin = $tr = $ts = "";
	$rand_svr = $rand_svr2 = "";
	$random_service_time_low_1 = $random_service_time_high_1 = $random_service_time_low_2 = $random_service_time_high_2 = "";
	$total_arrival_time = $tot_sr = 0;
	$s1 = $s2 = $s3 = 0;
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Analysis of Passengers' Flow in an Airport Terminal</title>
	<link rel="icon" type="image" href="Golden Dream logo3.ico" />
	<link rel="stylesheet" href="bootstrap.css" />
</head>
<body style="background:#45597f;">
	<div class="container-fluid" style="height:auto; padding:0; margin:15px auto; width:90%">
		<div class="well">
			<div class="well">
				<h3><strong><center>Analysis of Passengers' Flow in an Airport Terminal</center></strong></h3>
			</div>
			<img style="width:100%;height:200px;" src="passenger-flow.png" alt="passenger-flow" />
			
			<!-- -->
			<!--the html input part -->
			<div class="row">
				<div class="col-md-6">
					<div class="well" >
						<form action="pfat.php" method="POST" name="simulate">
							<table class="table-responsive">
								<tr>
									<td>Total Simulation Time</td>
									<td><input type="text" name="tst"> hrs</td>
								</tr>
								<br />
								<tr>
									<td>Arrival Time (1 to </td>
									<td><input type="text" name="rat"> min)</td>
								</tr>
								<br />
								<tr>
									<td>Random Service Time(desk 1) </td>
									<td><input type="text" name="rstl"> to <input type="text" name="rsth"> (min)</td>
								</tr>
								<br />
								<tr>
									<td>Random Service Time(desk 2) </td>
									<td><input type="text" name="rstl2"> to <input type="text" name="rsth2"> (min)</td>
								</tr>
								<br />
								<tr>
									<td>Percentage of Boarding</td>
									<td><input type="text" name="pb"> %</td>
								</tr>
								<br />
								<br />
								<tr>
									<td></td>
									<td><input type="submit" class="btn btn-primary pull-right" name="sim" value="Simulate"></td>
								</tr>
								
							</table>
						</form>
					</div>
				</div>
				<div class="col-md-6">
					<div class="well" >
						<table class="table-responsive">
						
<?php
	
	//start simulate
	if(isset($_POST['sim'])){
		
		//get all data posted
		$total_simulation_timeh = $_POST['tst'];
		$random_arrival_time = $_POST['rat'];
		$random_service_time_low_1 = $_POST['rstl'];
		$random_service_time_high_1 = $_POST['rsth'];
		$random_service_time_low_2 = $_POST['rstl2'];
		$random_service_time_high_2 = $_POST['rsth2'];
		$probability = $_POST['pb'];
		$total_simulation_time = $total_simulation_timeh*60;  //get total simulation in hour
		
		//create a loop of passengers from 0 to most likely infinity
		for($j = 0; $j < getrandmax(); $j++){
			
			//generate random values for arrival time
			$rand_arr = rand(0,1000);
			//a loop for creating arrival time table
			for($i = 1; $i < ($random_arrival_time+1); $i++){
				
				//creating probability
				$prob_arr = 1/$random_arrival_time;
				
				//creating random range
				$c_prob_arr = $prob_arr * $i * 1000;
				$c_prob_arr_1 = $prob_arr * ($i-1) * 1000;
				
				//if the value is in the range
				if($rand_arr > $c_prob_arr_1 && $rand_arr <= $c_prob_arr){
					
					//when the last range comes
					if($rand_arr == 0 || $rand_arr == 1000){
						$arrival_time = $random_arrival_time;
					}
					else{
						$arrival_time = $i;
					}
					//echo $arrival_time." ";
					break;
				}
				else
					continue;
			}
			
			//generate random values for server 1's service time
			$rand_svr = rand(0,100);
			//a loop for creating service time table
			for($m = $random_service_time_low_1; $m < ($random_service_time_high_1+1); $m++){
				
				//creating probability
				$prob_svr = 1/($random_service_time_high_1-$random_service_time_low_1+1);
				
				//creating random range
				$c_prob_svr = $prob_svr * ($m-$random_service_time_low_1+1) * 100;
				$c_prob_svr_1 = $prob_svr * ($m-$random_service_time_low_1) * 100;
						
				//if the value is in the range
				if($rand_svr > $c_prob_svr_1 && $rand_svr <= $c_prob_svr){
					
					//when the last range comes
					if($rand_svr == 0 || $rand_svr == 100){
						$service_time_1 = $random_service_time_high_1;
					}
					else{
						$service_time_1 = $m;
					}
					//echo "<br>".$service_time_1." ";
					break;
				}
				else
					continue;
			}			
		
			//the same action for server 2
			$rand_svr2 = rand(0,100);
			for($m = $random_service_time_low_2; $m < ($random_service_time_high_2+1); $m++){
				$prob_svr = 1/($random_service_time_high_2-$random_service_time_low_2+1);
				$c_prob_svr = $prob_svr * ($m-$random_service_time_low_2+1) * 100;
				$c_prob_svr_1 = $prob_svr * ($m-$random_service_time_low_2) * 100;
						
				if($rand_svr2 > $c_prob_svr_1 && $rand_svr2 <= $c_prob_svr){
					if($rand_svr2 == 0 || $rand_svr2 == 100){
						$service_time_2 = $random_service_time_high_2;
					}
					else{
						$service_time_2 = $m;
					}
					//echo "<br>".$service_time_1." ";
					break;
				}
				else
					continue;
			}
			//generate service time for all the servers
			
			/*
			 * calculate the time service ends for one customer
			 * initially total arrival time is 0
			 * service time added to total arrival time
			 * create time service ends for all three servers
			 * generate it for all customers respectively
			 */
			$service_time_end_1 = $total_arrival_time+$service_time_1;
			$service_time_end_2 = $total_arrival_time+$service_time_2;
			
			/*
			 * total arrival time calculated
			 * initially 0
			 * this value passed to another variable $tr
			 */
			$total_arrival_time = $total_arrival_time + $arrival_time;
			 $tr = $total_arrival_time;
			
			/*
			 * start assigning passenger to different desks
			 * we can see in the simulation table that 
			 * when the time service ends for a customer is bigger than the total arrival time for next customer
			 * then the server is called busy
			 * that means if the time service ends for a customer is less than the total arrival time for next customer
			 * the server is free and if equal it wiil be free
			 */
			
			//look if server 1 is free
			if($service_time_end_1 <= $tr){
				
				//then look if server to is free
				if($service_time_end_2 <= $tr){
					
					//if all are free look who take less time to finish
					//if server 1 takes less time then 2
					if($service_time_end_1 <= $service_time_end_2){
							
						//store the time service ends
						$ts = $service_time_end_1;
						//start calculate the passenger comes to this server
						$s1++;
					}
					else{
						$ts = $service_time_end_2;
						$s2++;
					}
				}
				else{
					$ts = $service_time_end_1;
					$s1++;
				}
			}
			
			//if server 1 is busy
			else{
				if($service_time_end_2 <= $tr){
					
					//go catch server 2
					$ts = $service_time_end_2;
					$s2++;
				}
				else
					continue;
			}
			//echo $tot_sr." ";			
			
			
			/*
			 * look when the simulation time is over
			 * check when the total arrival time equals the simulation time
			 * also check when the time service ends for of any server equals the simulation time
			 * get the total number of customer then 
			 */
			
			if($total_arrival_time >= $total_simulation_time){
				
				//when the total arrival time is bigger then simulation time
				if($total_arrival_time > $total_simulation_time){
					
					//go one step back and get total number of passenger 
					$tin = $j;
					$in = $tin+1;
					
					//this is the number of passengers enters				
					?>
					<tr>
						<td>Number of passengers in: </td>
						<td><?php echo $in;?></td>
					</tr>
					<br />
					<?php
					$tot_sr = $ts;
					if($tot_sr >= $total_simulation_time){
						
						//if the time service ends for of any server is bigger than the simulation time
						if($tot_sr > $total_simulation_time){
							
							//if this is server one 
							if($service_time_end_1 == $tot_sr){
								//if no customer comes before
								if($s1 <=0){
									//total the number of customer leaves any of the server within that time
									$k = $s1+$s2;
								}
								else{
									//go one step back to get total customer
									$s1--;
									$k = $s1+$s2;
								}
							}
							
							//again check for server 2
							if($service_time_end_2 == $tot_sr){
								if($s2 <=0){
									$k = $s1+$s2;
								}
								else{
									$s2--;
									$k = $s1+$s2;
								}
							}
							
							
							//get the rounded value of passengers okayed boarding
							$h = floor(($k*$probability)/100);
							
							//and who are not okayed
							$l = $k-$h;
							
							//and whose service not ended durating the simulation time
							$w = $in-$k;
							?>
							<tr>
								<td>Number of passengers out from TRS: </td>
								<td><?php echo $k;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers out from TRS1: </td>
								<td><?php echo $s1;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers out from TRS2: </td>
								<td><?php echo $s2;?></td>
							</tr>
							<br />
							
							<tr>
								<td>Number of passengers waiting for another simulation period: </td>
								<td><?php echo $w;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers whose boarding is ok: </td>
								<td><?php echo $h;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers whose boarding is not ok: </td>
								<td><?php echo $l;?></td>
							</tr>
							<?php
						}
						
						//do the same for when the time service ends equals the simulation time
						else{
							$k = $s1+$s2;
							$h = floor(($k*$probability)/100);
							$l = $k-$h;
							$w = $in-$k;
							?>
							<tr>
								<td>Number of passengers out from TRS: </td>
								<td><?php echo $k;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers out from TRS1: </td>
								<td><?php echo $s1;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers out from TRS2: </td>
								<td><?php echo $s2;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers waiting for another simulation period: </td>
								<td><?php echo $w;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers whose boarding is ok: </td>
								<td><?php echo $h;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers whose boarding is not ok: </td>
								<td><?php echo $l;?></td>
							</tr>
							<?php
						}
						break;
					}
					else
						continue;
						
					break;
				}
				
				//do the same for when the total arrival time equals the simulation time
				else{
					$tin = $j;
					$in = $tin+2;
							
					?>
					<tr>
						<td>Number of passengers in: </td>
						<td><?php echo $in;?></td>
					</tr>
					<br />
					<?php
					$tot_sr = $ts;
					if($tot_sr >= $total_simulation_time){
						if($tot_sr > $total_simulation_time){
							if($service_time_end_1 == $tot_sr){
								if($s1 <=0){
									$k = $s1+$s2;
								}
								else{
									$s1--;
									$k = $s1+$s2;
								}
							}
							if($service_time_end_2 == $tot_sr){
								if($s2 <=0){
									$k = $s1+$s2;
								}
								else{
									$s2--;
									$k = $s1+$s2;
								}
							}
							
							
							$h = floor(($k*$probability)/100);
							$l = $k-$h;
							$w = $in-$k;
							?>
							<tr>
								<td>Number of passengers out from TRS: </td>
								<td><?php echo $k;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers out from TRS1: </td>
								<td><?php echo $s1;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers out from TRS2: </td>
								<td><?php echo $s2;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers out from TRS3: </td>
								<td><?php echo $s3;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers waiting for another simulation period: </td>
								<td><?php echo $w;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers whose boarding is ok: </td>
								<td><?php echo $h;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers whose boarding is not ok: </td>
								<td><?php echo $l;?></td>
							</tr>
							<?php
						}
						else{
							$k = $s1+$s2;
							$h = floor(($k*$probability)/100);
							$l = $k-$h;
							$w = $in-$k;
							?>
							<tr>
								<td>Number of passengers out from TRS: </td>
								<td><?php echo $k;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers out from TRS1: </td>
								<td><?php echo $s1;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers out from TRS2: </td>
								<td><?php echo $s2;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers waiting for another simulation period: </td>
								<td><?php echo $w;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers whose boarding is ok: </td>
								<td><?php echo $h;?></td>
							</tr>
							<br />
							<tr>
								<td>Number of passengers whose boarding is not ok: </td>
								<td><?php echo $l;?></td>
							</tr>
							<?php
						}
						break;
					}
					else
						continue;
						
					break;
				}
				
				break;
			}
			else
				continue;
				
				
				
				
					
		}
		
	}

?>			
							
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>