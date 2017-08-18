server = Wscript.Arguments(0)   '"Wserver" '
user   = Wscript.Arguments(1)   '"Wserver\Administrateur"
pass   = Wscript.Arguments(2)   '"root"'

Set locator = CreateObject("WbemScripting.SWbemLocator")
Set svc = locator.ConnectServer(server , "\root\cimv2", user,pass)
svc.Security_.ImpersonationLevel = 3


Set colItems = svc.ExecQuery("SELECT * FROM Win32_LogicalDisk WHERE DriveType = '3'")
For Each objItem In colItems
         Wscript.Echo  objItem.Name & vbCrLf & Round(Cdbl(objItem.Size) / 1073741824) & vbCrLf & Round(CDbl(objItem.FreeSpace) / 1073741824) & vbCrLf & server
Next

WScript.Quit





