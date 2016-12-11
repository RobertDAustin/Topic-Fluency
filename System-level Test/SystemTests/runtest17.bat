ECHO on
Set Case=17
ECHO Running System Test %Case%

del settings.cfg

REM -- Run the robot script
java -cp %CLASSPATH%;../Conquest.jar TestTools.MyRobot SysTest%Case%\robotscript%Case%A.rsf

REM -- Check the settings report results
FC SysTest%Case%\oracle\settingsReportA.txt settingsReport.txt >> testlog.txt


REM -- Run the robot script
java -cp %CLASSPATH%;../Conquest.jar TestTools.MyRobot SysTest%Case%\robotscript%Case%B.rsf

REM -- Check the settings report results
FC SysTest%Case%\oracle\settingsReportB.txt settingsReport.txt >> testlog.txt
ECHO "Finished Testcase %Case%" >> testlog.txt

