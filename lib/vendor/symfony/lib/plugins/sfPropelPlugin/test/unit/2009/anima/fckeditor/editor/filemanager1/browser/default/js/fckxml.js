﻿/*
 * File Name: fckxml.js
 * 	Defines the FCKXml object that is used for XML data calls
 * 	and XML processing.
 * 	This script is shared by almost all pages that compose the 
 * 	File Browser frameset.
 * File Authors:
 * 		Frederico Caldeira Knabben (www.fckeditor.net)
 */

var FCKXml = function() {}

FCKXml.prototype.GetHttpRequest = function() {
	// Gecko / IE7
	if ( typeof(XMLHttpRequest) != 'undefined' )
		return new XMLHttpRequest() ;

	// IE6
	try { return new ActiveXObject( 'Msxml2.XMLHTTP' ) ; } 
	catch(e) {}

	// IE5
	try { return new ActiveXObject( 'Microsoft.XMLHTTP' ) ; }
	catch(e) {}

	return null ;
}

FCKXml.prototype.LoadUrl = function( urlToCall, asyncFunctionPointer )
{
	var oFCKXml = this ;

	var bAsync = ( typeof(asyncFunctionPointer) == 'function' ) ;

	var oXmlHttp = this.GetHttpRequest() ;
		
	oXmlHttp.open( "GET", urlToCall, bAsync ) ;

	if ( bAsync )
	{	
		oXmlHttp.onreadystatechange = function() 
		{
			if ( oXmlHttp.readyState == 4 )
			{
				if ( oXmlHttp.responseXML == null || oXmlHttp.responseXML.firstChild == null)
				{
					alert( 'The server didn\'t send back a proper XML response.\r\n\r\n' +
							'Requested URL: ' + urlToCall + '\r\n' +
							'Response text:\r\n' + oXmlHttp.responseText ) ;
					return ;
				}
				oFCKXml.DOMDocument = oXmlHttp.responseXML ;
				if ( oXmlHttp.status == 200 || oXmlHttp.status == 304 )
					asyncFunctionPointer( oFCKXml ) ;
				else
					alert( 'XML request error: ' + oXmlHttp.statusText + ' (' + oXmlHttp.status + ')' ) ;
			}
		}
	}
	
	oXmlHttp.send( null ) ;
	
	if ( ! bAsync )
	{
		if ( oXmlHttp.status == 200 || oXmlHttp.status == 304 )
			this.DOMDocument = oXmlHttp.responseXML ;
		else
		{
			alert( 'XML request error: ' + oXmlHttp.statusText + ' (' + oXmlHttp.status + ')' ) ;
		}
	}
}

FCKXml.prototype.SelectNodes = function( xpath )
{
	if ( navigator.userAgent.indexOf('MSIE') >= 0 )		// IE
		return this.DOMDocument.selectNodes( xpath ) ;
	else					// Gecko
	{
		var aNodeArray = new Array();

		var xPathResult = this.DOMDocument.evaluate( xpath, this.DOMDocument, 
				this.DOMDocument.createNSResolver(this.DOMDocument.documentElement), XPathResult.ORDERED_NODE_ITERATOR_TYPE, null) ;
		if ( xPathResult ) 
		{
			var oNode = xPathResult.iterateNext() ;
 			while( oNode )
 			{
 				aNodeArray[aNodeArray.length] = oNode ;
 				oNode = xPathResult.iterateNext();
 			}
		} 
		return aNodeArray ;
	}
}

FCKXml.prototype.SelectSingleNode = function( xpath ) 
{
	if ( navigator.userAgent.indexOf('MSIE') >= 0 )		// IE
		return this.DOMDocument.selectSingleNode( xpath ) ;
	else					// Gecko
	{
		var xPathResult = this.DOMDocument.evaluate( xpath, this.DOMDocument,
				this.DOMDocument.createNSResolver(this.DOMDocument.documentElement), 9, null);

		if ( xPathResult && xPathResult.singleNodeValue )
			return xPathResult.singleNodeValue ;
		else	
			return null ;
	}
}
