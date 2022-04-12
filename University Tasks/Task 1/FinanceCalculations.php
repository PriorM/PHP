<html>
	<head>
		<center><h1>Mo' Money, Less Problems</h1>
		<img src="fin_945x493.jpg" alt="FINANCE"></center>
	</head>
	<body>
		<center><p>Finance is really important, use this to calculate your monthly payments</p>
		<form action="FinanceCalculations.php" method="post">
			Amount of Mortgage:	<input type="text" name="loan" value="<?php if (isset($_POST['loan'])) echo $_POST['loan']; ?>"><br/>
			Interest Rate: <input type="text" name="rate" value="<?php if (isset($_POST['rate'])) echo $_POST['rate']; ?>"><br/>
			Number of Years: <input type="text" name="paymentsNumber" value="<?php if (isset($_POST['paymentsNumber'])) echo $_POST['paymentsNumber']; ?>"><br/>
			<input type="submit" value="Calculate" name="Calculate">
		</form>
		
		<?php
			function calculate_Payments()
			{
				$loan = trim($_POST["loan"]);
				$rate = trim($_POST["rate"]);
				$paymentsNumber = trim($_POST["paymentsNumber"]);
				
				$loan = preg_replace('/\s(?=\s)/', '', $loan);
				$rate = preg_replace('/\s(?=\s)/', '', $rate);
				$paymentsNumber = preg_replace('/\s(?=\s)/', '', $paymentsNumber);
				
				$loan = preg_replace('/[^0-9.-]/', '', $loan);
				$rate = preg_replace('/[^0-9.-]/', '', $rate);
				$paymentsNumber = preg_replace('/[^0-9.-]/', '', $paymentsNumber);
				
				$rate = $rate / 12;
				$paymentsNumber = $paymentsNumber * 12;
				
				$monthlyPayments = (($loan * $rate) / (1.0 - (1.0 / (1.0 + $rate) ** $paymentsNumber)));
				echo "Monthly Payments are: $", $monthlyPayments;
			}
			
			if(isset($_POST["Calculate"]))
			{
			   calculate_Payments();
			} 
		?>
		</center>
	</body>
</html>
