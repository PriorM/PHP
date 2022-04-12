<html>
	<head>
	</head>
	<body>
		<center>
		<h3>Seller</h3> <br/>
		<form action="CarSales.php" method="post">
			Name: <input type="text" name="name"> <br/>
			Email: <input type="text" name="email"> <br/>
			Phone Number: <input type="text" name="phone"> <br/>
			Car Characteristics: <textarea name="car" rows="5" cols="40"></textarea><br/>
			Price: $ <input type="text" name="price"> <br/>
			Plate: <input type="text" name="plate"> <br/>
			<input type="submit" value="Submit" name="sellerSubmit">
		</form>
		<br/>
		<h3>Search</h3><br/>
		<form action="CarSales.php" method="post">
			Plate: <input type="text" name="plateSearch">
			<input type="submit" value="Search" name="search">
		</form>
		<br/>
		<h3>Buyer</h3><br/>
		<form action="CarSales.php" method="post">
			Wanted Car Plate: <input type="text" name="wantedPlate"> <br/>
			Proposed Price: $ <input type="text" name="propPrice"> <br/>
			Buyer Name: <input type="text" name="buyerName"> <br/>
			Buyer Phone Number: <input type="text" name="buyerPhone"> <br/>
			<input type='submit' value='Interested' name='interest'>
		</form>
		</center>
	
	
		<?php
		
			function validate_email($email)
			{
				return preg_match ('/^[a-z0-9_-][a-z0-9._-]+@([a-z0-9][a-z0-9-]*\.)+[a-z]{2,6}$/i', $email);
			}
			
			if (isset($_POST["sellerSubmit"]))
			{
				$name = "";
				if(isset($_POST["name"]))
					$name = trim($_POST["name"]);
				$email = "";
				if(isset($_POST["email"]))
				{
					$email = trim($_POST["email"]);
					validate_email($email);
				}
				$phone = "";
				if(isset($_POST["phone"]))
					$phone = trim($_POST["phone"]);
				$car = "";
				if(isset($_POST["car"]))
					$car = trim($_POST["car"]);
				$price = "";
				if(isset($_POST["price"]))
					$price = trim($_POST["price"]);
				$plate = "";
				if(isset($_POST["plate"]))
					$plate = trim($_POST["plate"]);
				
				preg_replace('/\s(?=\s)/', '', $price);
				preg_replace('/[^0-9.-]/', '', $price);
					
				
				$sellers = fopen("directory.txt" , "a") or die("Unable to open file!");
				fwrite($sellers, $name.",");
				fwrite($sellers, $email.",");
				fwrite($sellers, $phone.",");
				fwrite($sellers, $car.",");
				fwrite($sellers, $price.",");
				fwrite($sellers, $plate."\n\r");
				fclose($sellers);
			}
			
			if (isset($_POST["search"]))
			{
				$plateSearch = "";
				if(isset($_POST["plateSearch"]))
					$plateSearch = trim($_POST["plateSearch"]);
			
				
				if (isset($_POST["search"]))
				{
					if ($plateSearch != "")
					{
						$directory = fopen("directory.txt", "r") or die("Unable to open file!");
						
						if($directory)
						{
							echo "Searched Plate: ".$plateSearch."<br/>";
							
							while (!feof($directory))
							{
								$data = explode(",", fgets($directory, 65534));
								
								if (isset($data[5]))
								{
									if (trim($data[5]) == $plateSearch)
									{
										echo "Number Plate: ".$data[5]."<br/>";
										echo "Owner Name: ".$data[0]."<br/>";
										echo "Email: ".$data[1]."<br/>";
										echo "Phone Number: ".$data[2]."<br/>";
										echo "Details: ".$data[3]."<br/>";
										echo "Price: $".$data[4]."<br/>";
									}
								}
							}
						}
						
						fclose($directory);
					}
				}
			}
			if (isset($_POST["interest"]))
			{
				$buyerName = "";
				if(isset($_POST["buyerName"]))
					$buyerName = trim($_POST["buyerName"]);
				$buyerPhone = "";
				if(isset($_POST["buyerPhone"]))
					$buyerPhone = trim($_POST["buyerPhone"]);
				$wantedPlate = "";
				if(isset($_POST["wantedPlate"]))
					$wantedPlate = trim($_POST["wantedPlate"]);
				$propPrice = "";
				if(isset($_POST["propPrice"]))
					$propPrice = trim($_POST["propPrice"]);
				
				preg_replace('/\s(?=\s)/', '', $propPrice);
				preg_replace('/[^0-9.-]/', '', $propPrice);
				
				$buyers = fopen("buyer.txt", "a") or die("Unable to open file!");
				fwrite($buyers, $buyerName.",");
				fwrite($buyers, $buyerPhone.",");
				fwrite($buyers, $wantedPlate.",");
				fwrite($buyers, $propPrice."\n\r");
				fclose($buyers);
			}
		?>
	</body>
</html>
