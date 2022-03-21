*CONTENTS*

statistics.pdf is the pdf file with results of the analysis

script.txt contains lines of script that we used to parse log data 

sorted_access_log.txt is the log with requests of group8 only

sorted_error_log.txt is the log with errors of group8 only

*EXPLANATION*

This is a step-by-step explanation of how the assignment was done.

0) We did some clicks on the site http://clabsql.clamv.jacobs-university.de/~drudenko/
   So we generated some entreis of the access_log. 
   We also generated some errors, since we did not have any. In particular, we temporary removed courses.php to get 404.

1) access_log and error_log files were fetched to my computer

2) the following script was used to sort log files:

	cat access_log | grep drudenko > sorted_access_log.txt

	cat error_log | grep drudenko > sorted_error_log.txt

3) we then downloaded goaccess tool: https://goaccess.io

4) to use the tool, we had to figure out the formats of log files; 
   for that we investigated into the manual pages of strftime (type "man strftime" in the terminal), and apache log formats here https://httpd.apache.org/docs/2.4/logs.html

5) the following lines created diagrams for us:

	goaccess sorted_error_log.txt -o error_report.html --log-format='[%^ %d %t.%^ %^] [%^] [%^] [%^ %h:%^] %^: %U, %^: %R' --time-format=%T --date-format='%b %d'

	goaccess sorted_access_log.txt -o access_report.html --log-format=COMBINED

P.S. since we have figured out the format, we could parse the details ourselves, 
     but we would still have to do diagrams manually. So, why not use a tool from Internet?