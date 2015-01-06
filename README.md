Number To Text Converter
============

Inspired by Peter Ajtai solution, which you can find [here](http://peter-ajtai.com/examples/numbers.php).


This code allows you easily convert numbers in the range from -999,999,999 to 999,999,999 into words in English, Ukrainian or Russian. 
There are 3 main classes (1 class for each language), to convert number you should use convertNumber method:
```php
echo ConvertToEnglish::convertNumber(1234); 
// outputs "one thousand two hundred and thirty-four"
```

This code is free software, so feel free to copy, change and modify it accordingly to your needs.
