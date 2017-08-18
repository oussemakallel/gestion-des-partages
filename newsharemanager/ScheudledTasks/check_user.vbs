'authentification info'
server = Wscript.Arguments(0)
user   = Wscript.Arguments(1)
pass   = Wscript.Arguments(2)
name   = Wscript.Arguments(3)



Set locator = CreateObject("WbemScripting.SWbemLocator")
Set svc = locator.ConnectServer(server, "\root\cimv2", user, pass)
svc.Security_.ImpersonationLevel = 3
Set colWinAcc = Svc.ExecQuery("SELECT * FROM Win32_ACCOUNT WHERE Name='" & name & "'") 

Wscript.Echo colWinAcc.Count 
 Wscript.Quit
