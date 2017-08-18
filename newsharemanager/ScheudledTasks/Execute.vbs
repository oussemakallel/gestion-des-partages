
'authentification info'
server = Wscript.Arguments(0)
user   = Wscript.Arguments(1)
pass   = Wscript.Arguments(2)
'command
cmd    = Wscript.Arguments(3)


Set locator = CreateObject("WbemScripting.SWbemLocator")
Set svc = locator.ConnectServer(server, "\root\cimv2:Win32_Process", user,pass)
svc.Security_.ImpersonationLevel = 3
Set objProcess = svc.Get("Win32_Process")

errReturn = objProcess.Create( cmd, Null, Null, intProcessID )

WScript.Quit