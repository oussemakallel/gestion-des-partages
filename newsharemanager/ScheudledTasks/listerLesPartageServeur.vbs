serveur = Wscript.Arguments(0)
user    = Wscript.Arguments(1)
pass    = Wscript.Arguments(2)

strComputer = serveur 

Set objSWbemLocator = CreateObject("WbemScripting.SWbemLocator")
Set objWMIService = objSWbemLocator.ConnectServer(strComputer,"root\cimv2",user,pass,MS409)
Set colShares = objWMIService.ExecQuery("Select * from Win32_Share Where Type=0")
For each objShare in colShares 
          Wscript.Echo(objShare.Name)  
          Wscript.Echo(objShare.Path) 
         'Wscript.Echo("Type: " & objShare.Type) 
          'Wscript.Echo             "Allow Maximum: " & objShare.AllowMaximum 
          'Wscript.Echo             "Maximum Allowed: " & objShare.MaximumAllowed 
          'Wscript.Echo             "Caption: " & objShare.Caption 
          Wscript.Echo(0) 
          'Size(Serveur,objShare.Path,user,pass) & vbCrLf
          Wscript.Echo(serveur) 

    Set colItems = objWMIService.ExecQuery("SELECT * FROM Win32_LogicalShareSecuritySetting where Name='"& objShare.Name &"'",,48)
    For Each Item in colItems 
    Dim wmiSecurityDescriptor
    RetVal = Item. GetSecurityDescriptor(wmiSecurityDescriptor) 
    colDACLs = wmiSecurityDescriptor.DACL
If IsCollection(colDACLs) THEN
    For Each objACE In colDACLs
    Set objUserGroup = objACE.Trustee 
			UserGroup = objUserGroup.Name
			Select Case objACE.AccessMask
				Case 1179817 strPermission = "READ"
				Case 1245631 strPermission = "CHANGE"
				Case 2032127 strPermission = "FULL"
			End Select
			Permission = strPermission
			Wscript.Echo(Cstr(UserGroup))
			Wscript.Echo(Permission)

			
		Next 
    END IF
    
    Next
        Wscript.Echo("***")
Next
 
'Wscript.Echo "Network Share Folders in Remote Computer listed successfully"
Function Size(Serveur,path,user,pass)
	path2 = replace(path,":","$")
	path2 = "\\" & serveur & "\" & path2
	Set objShell = CreateObject("Wscript.Shell")
    Retour1 = objShell.run("cmd /c net use " & path2 & " /user:" & user & " " & pass ,6,true)
	Set objFSO = CreateObject("Scripting.FileSystemObject")
	Set objFolder = objFSO.GetFolder(path2)
    Size =  Replace(Round(objFolder.Size/(1024*1024*1024),6),",",".")
End Function
Function IsCollection(param)
    On Error Resume Next
    For Each p In param
        Exit For
    Next
    If Err Then
        If Err.Number = 451 Then
            IsCollection = False
        Else
            IsCollection = False
        End If
    Else
        IsCollection = True
    End If
End Function



WScript.Quit
