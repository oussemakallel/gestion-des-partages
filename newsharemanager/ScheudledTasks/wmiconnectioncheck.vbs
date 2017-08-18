serveur = Wscript.Arguments(0)
user    = Wscript.Arguments(1)
pass    = Wscript.Arguments(2)

strComputer = serveur 
On Error Resume Next
Set objSWbemLocator = CreateObject("WbemScripting.SWbemLocator")
Set objWMIService = objSWbemLocator.ConnectServer(".","root\cimv2","","",MS409)

IF objWMIService THEN
    Wscript.Echo "OK"
ELSE
    Wscript.Echo "FAIL"
END IF
Wscript.Quit