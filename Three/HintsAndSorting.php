<html>
	<title>
		Arrays - Lab Number 33
	</title>
	<head>
		<center><h1>Arrays</h1></center>
	</head>
	<body>
		<?php
			//TASK ONE
			
			//Hint 1
			$array = array();
			
			//Hint 2
			$array = array_fill(0, 12, "a");
			
			//Hint 3
			$size = count($array);
			
			//Hint 4
			$arrayRange = range(0, 11, 1);
			
			//Hint 5
			$big_array = array_merge($array, $arrayRange);
			
			//Hint 6
			$two_d_array = array_chunk($arrayRange, 6);
			
			//Hint 7
			$key_based_array = array_combine($arrayRange, $array);
			
			//Hint 8
			$subarray = array_slice($arrayRange, 3, 5);
			
			//Hint 9
			$extracted = array_splice($array, 3, 3, $arrayRange);
			
			//Hint 10
			$sorted = asort($arrayRange);
			$reverse = arsort($arrayRange);
			
			//Hint 11
			$sorted = ksort($key_based_array);
			$reversed = krsort($key_based_array);
			
			//Hint 12
			$counts = array_count_values($big_array);
			
			//Hint 13
			$exists = array_key_exists(3, $key_based_array);
			
			//Hint 14
			$key_array = array_keys($key_based_array);
			
			//Hint 15
			$value_array = array_values($key_based_array);
			
			//Hint 16
			$result = array_unique($big_array);
			
			//Hint 17
			$diff = array_diff($arrayRange, $big_array);
			
			//Hint 18
			$flipped = array_flip($key_based_array);
			
			//Hint 19
			$common = array_intersect($arrayRange, $big_array);
			
			//Hint 20
			$randArray = array_rand($result, 5);



			//TASK TWO
			
			//create a nested array structure
			$scores = array (
			'Siegfried' => array(117, 72, 53.3),
			'Francesca' => array(84.7),
			'Jonathas' => array(96.7, 37),
			'Mika' => array(113, 100, 81),
			'Timothy' => array(80.7, 80.3, 89),
			);
			
			echo '<pre>';
			echo 'Unsorted: </br>';
			print_r(array_keys($scores));
			
			//create a function that will sort based upon the length of the subarray
			function compare_length($a, $b)
			{
				//For each look at the length of the subarray
				$a_length = count($a);
				$b_length = count($b);
				
				//If they're the same, return 0
				if ($a_length == $b_length)
				{
					return 0;
				}
				else
				{
					return ($a_length < $b_length) ? -1 : 1;
				}
			}
			
			//using that formula, sort the array, keeping the key associations intact
			uasort($scores, 'compare_length');
			
			//Keys in new order
			echo '<pre>';
			echo 'Sorted by array length: </br>';
			print_r(array_keys($scores));
			
			//create function to sort array by maximum value in the subarray
			function compare_max($a, $b)
			{
				$a_max = max($a);
				$b_max = max($b);
				
				//if same, return 0
				if ($a_max == $b_max)
				{
					return 0;
				}
				else
				{
					return ($a_max < $b_max) ? -1 : 1;
				}
			}
			
			//resort by max value
			uasort($scores, 'compare_max');
			
			echo 'Sorted by array maximum value: </br>';
			print_r(array_keys($scores));
			echo '</pre>';
		?>	
	</body>
</html>
