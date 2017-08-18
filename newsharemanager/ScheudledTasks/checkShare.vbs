'authentification info'
server = Wscript.Arguments(0)
user   = Wscript.Arguments(1)
pass   = Wscript.Arguments(2)
share  = Wscript.Arguments(3)


Set locator = CreateObject("WbemScripting.SWbemLocator")
Set svc = locator.ConnectServer(server, "\root\cimv2", user, pass)
svc.Security_.ImpersonationLevel = 3
Set colShares = svc.ExecQuery("Select * from Win32_Share where name = '"&share&"'")
Wscript.echo colShares.count
Wscript.Quit