
'authentification info'
server = Wscript.Arguments(0)
user   = Wscript.Arguments(1)
pass   = Wscript.Arguments(2)
drive  = Wscript.Arguments(3)

Set locator = CreateObject("WbemScripting.SWbemLocator")
Set svc = locator.ConnectServer(server, "\root\cimv2:Win32_Process", user, pass)
svc.Security_.ImpersonationLevel = 3

Set colDisks = svc.ExecQuery ("Select * from Win32_LogicalDisk where DeviceID = '"&drive&":' ")

For Each objDisk in colDisks
    Wscript.echo objDisk.FreeSpace/(1024*1024*1024)
Next

WScript.Quit
