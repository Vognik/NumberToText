<?php
	abstract class Converter {
    	public static function convertNumber($number, $isRecursiveFromThousand = false) {
      		$maxSize = pow(10,9);

      		if (abs($number) < $maxSize) {
				$number = intval($number);
				if (empty($number)) return static::$words[0];
				
				switch ($number) {
					case $number < 0:
						$string = self::convertNegative($number);
						return $string;

				  	case 1:
				  	case 2:
						$string = $isRecursiveFromThousand ? static::$words[$number."th"] : static::$words[$number];
						return $string;

				  	case ($number < 21) || ($number < 100 && $number % 10 === 0):
						$string = static::$words[$number];
						return $string;

				  	case $number < 100:
						$string = self::convertTens($number, $isRecursiveFromThousand);
						return $string;

				  	case $number < pow(10,3):
						$string = self::convertHundreds($number, $isRecursiveFromThousand);
						return $string;
					
				  	case $number < pow(10,6):
						$string = self::convertThousands($number);
						return $string;

				  	case $number < pow(10,9):
						$string = self::convertMillions($number);
						return $string;
				}
			} else {
				echo static::$words["error"].number_format($maxSize-1)." ".static::$words["to"]." ".number_format($maxSize-1);
			}
		}
		
		private function convertNegative($number) {
			$prefix = static::$words["negative"];
			$suffix = self::convertNumber(-1*$number);
			$string = $prefix." ".$suffix;
			return $string;								
		}

		private function convertTens($number, $isRecursiveFromThousand) {
			$prefix = self::convertNumber($number-$number%10, $isRecursiveFromThousand);
			$suffix = self::convertNumber($number%10, $isRecursiveFromThousand);
			$string = $prefix.static::$words["conc"].$suffix;
			return $string;
		}

		private function convertHundreds($number, $isRecursiveFromThousand) {
			if ($number % 100 === 0) {
			  $string = static::$words[$number];
			} else {
			  $prefix = static::$words[$number - $number%100];
			  $suffix = static::$words["conc2"] . self::convertNumber($number%100, $isRecursiveFromThousand);
			  $string = $prefix.$suffix;
			}
			return $string;
		}

		private function convertThousands($number) {
			$prefix = self::convertNumber(floor($number/pow(10,3)), true)." ";
			$lastDigit = substr(floor($number/pow(10,3)), -1);
			$lastTwoDigits = floor($number/pow(10,3)) > 9 ? substr(floor($number/pow(10,3)), -2) : "";

			if ($lastDigit == 1 && $lastTwoDigits != 11) {
				$prefix .= static::$words[1001];
			} elseif(($lastDigit == 2 || $lastDigit == 3 || $lastDigit == 4) &&
				$lastTwoDigits != 12 && $lastTwoDigits != 13 && $lastTwoDigits != 14) {
				$prefix .= static::$words[1002];
			} else {
				$prefix .= static::$words[1003];
			}
			$suffix = $number%pow(10,3) ? self::convertNumber($number%pow(10,3)) : "";
			$string = $prefix . " " . $suffix;
			return $string;
		}

		private function convertMillions($number) {
			$prefix = self::convertNumber(floor($number/pow(10,6)))." ";
			$lastTwoDigits = floor($number/pow(10,6)) > 9 ? substr(floor($number/pow(10,6)), -2) : "";
			$lastDigit = substr(floor($number/pow(10,6)), -1);

			if ($lastDigit == 1 && $lastTwoDigits != 11) {
				$prefix .= static::$words["m1"];
			} elseif(($lastDigit == 2 || $lastDigit == 3 || $lastDigit == 4) &&
				$lastTwoDigits != 12 && $lastTwoDigits != 13 && $lastTwoDigits != 14) {
				$prefix .= static::$words["m2"];
			} else {
				$prefix .= static::$words["m3"];
			}

			$suffix = $number%pow(10,6) ? self::convertNumber($number%pow(10,6)) : "";
			$string = $prefix." ".$suffix;
			return $string;
		}
	}
  
  	class ConvertToEnglish extends Converter {
		public static $words = array("negative" => "negative ", 0 => "zero", 1 => "one", "1th" => "one", 2 => "two", "2th" => "two", 3 => "three", 4 => "four", 5 => "five", 6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen", 16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 19 => "nineteen", 20 => "twenty", 30 => "thirty", 40 => "forty", 50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty", 90 => "ninety", 100 => "one hundred", 200 => "two hundred", 300 => "three hundred", 400 => "four hundred", 500 => "five hundred", 600 => "six hundred", 700 => "seven hundred", 800 => "eight hundred", 900 => "nine hundred", 1001 => "thousand", 1002 => "thousand", 1003 => "thousand", "m1" => "million", "m2" => "million", "m3" => "million", "conc" => "-", "conc2" => " and ", "error" => "ERROR<br> Number must be an integer from -", "to" => "to");
	}
  
  	class ConvertToUkrainian extends Converter {
    	public static $words = array("negative" => "мінус ", 0 => "нуль", 1 => "один", "1th" => "одна", 2 => "два", "2th" => "дві", 3 => "три", 4 => "чотири", 5 => "п'ять", 6 => "шість", 7 => "сім", 8 => "вісім", 9 => "дев'ять", 10 => "десять", 11 => "одинадцять", 12 => "дванадцять", 13 => "тринадцять", 14 => "чотирнадцять", 15 => "п'ятнадцять", 16 => "шістнадцять", 17 => "сімнадцять", 18 => "вісімнадцять", 19 => "дев'ятнадцять", 20 => "двадцять", 30 => "тридцять", 40 => "сорок", 50 => "п'ятдесят", 60 => "шістдесят", 70 => "сімдесят", 80 => "вісімдесят", 90 => "дев'яносто", 100 => "сто", 200 => "двісті", 300 => "триста", 400 => "чотириста", 500 => "п'ятсот", 600 => "шістсот", 700 => "сімсот", 800 => "вісімсот", 900 => "дев'ятсот", 1001 => "тисяча", 1002 => "тисячі", 1003 => "тисяч", "m1" => "мільйон", "m2" => "мільйона", "m3" => "мільйонів", "conc" => " ", "conc2" => " ", "error" => "Помилка<br> Число має бути цілим в діапазоні від -", "to" => "до");
  	}
  
  	class ConvertToRussian extends Converter {
    	public static $words = array("negative" => "минус ", 0 => "ноль", 1 => "один", "1th" => "одна", 2 => "два", "2th" => "две", 3 => "три", 4 => "четыре", 5 => "пять", 6 => "шесть", 7 => "семь", 8 => "восемь", 9 => "девять", 10 => "десять", 11 => "одинадцать", 12 => "двенадцать", 13 => "тринадцать", 14 => "четырнадцать", 15 => "пятнадцать", 16 => "шестнадцать", 17 => "семнадцать", 18 => "восемнадцать", 19 => "девятнадцать", 20 => "двадцать", 30 => "тридцать", 40 => "сорок", 50 => "пятьдесят", 60 => "шестьдесят", 70 => "семьдесят", 80 => "восемьдесят", 90 => "девяносто", 100 => "сто", 200 => "двести", 300 => "триста", 400 => "четыреста", 500 => "пятьсот", 600 => "шестьсот", 700 => "семьсот", 800 => "восемьсот", 900 => "девятьсот", 1001 => "тысяча", 1002 => "тысячи", 1003 => "тысяч", "m1" => "миллион", "m2" => "миллиона", "m3" => "миллионов", "conc" => " ", "conc2" => " ", "error" => "Ошибка<br> Число должно быть целым в диапазоне от -", "to" => "до");
  	}
  	
