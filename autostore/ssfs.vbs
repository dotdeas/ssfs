'
' SSFS AutoStore Script
' (c) 2016 .DEAS Solutions
'
' Version: 1.0
' By: Andreas Persson
' Email: andreas@dotdeas.se
'
' Required strings (set in VB component)
' --------------------------------------
' strFileid => fileidentifier/name
' strOcrdata => filtered ocr data from ocr and data filter components
'

Sub writelog(input)
	EKOManager.StatusMessage "SSFS: "+input
End Sub

Sub ssfsplugin_OnLoad()
	writelog("Entering SSFS (ver. 1.0) ...")

	' Database config
	strDbdriver = ""
	strDbhost = ""
	strDbname = "ssfs"
	strDbuser = ""
	strDbpass = ""

	On Error Resume Next

	strDate = Year(Now())&"-"&Month(Now())&"-"&Day(Now())

	writelog("Connecting to mysql server ...")
	Set conn = CreateObject("ADODB.Connection")
	conn.Open "Driver="+strDbdriver+";Server="+strDbhost+";Database="+strDbname+";Uid="+strDbuser+";Password="+strDbpass
	If conn.state = "1" Then
		writelog("Connected to mysql server")
		Set rs = CreateObject("ADODB.Recordset")
		Set rs = conn.Execute("SELECT COUNT(fileid) FROM archive WHERE fileid='"+strFileid+"'")
		If rs("count(fileid)")<>"0" Then
			writelog("Record allready exists, updating record ...")
			Set rs = conn.Execute("UPDATE archive SET filedata='"+strOcrdata+"' WHERE fileid='"+strBarcode+"'")
		Else
			writelog("Inserting record to database ...")
			Set rs = conn.Execute("INSERT INTO archive (fileid,filedate,filedata) VALUES ('"+strFileid+"','"+strDate+"','"+strOcrdata+"')")
		End If
		writelog("Disconnecting from mysql server ...")
		Set rs = Nothing
		conn.Close
	Else
		writelog("Could not to mysql server")
		KnowledgeObject.Status = 2
	End If
End Sub

Sub ssfsplugin_OnUnload()
	writelog("Exiting SSFS ...")
End Sub