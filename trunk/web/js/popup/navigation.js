var arrCheckItem = null;

function fnCheckItem(ID) {
  var elementname = "check" + ID;
  var objCheckbox = document.getElementById(elementname);

  if(arrCheckItem == null)arrCheckItem = new Array;

  if (objCheckbox && objCheckbox.checked) {
    arrCheckItem.push(ID);

  } else if (objCheckbox && !objCheckbox.checked) {
    for(cnt = 0; cnt < arrCheckItem.length; cnt++) {
      if (arrCheckItem[cnt] == ID) {
        arrCheckItem.splice(cnt, 1);
        break;
      }
    }
  }


  if (arrCheckItem.length > 0) {
    if (document.getElementById("copyLink")) {
      document.getElementById("copyLink").disabled = false;
    }
    if (document.getElementById("moveLink")) {
      document.getElementById("moveLink").disabled = false;
    }
    document.getElementById("deleteLink").disabled = false;
  } else {
    if (document.getElementById("copyLink")) {
      document.getElementById("copyLink").disabled = true;
    }
    if (document.getElementById("moveLink")) {
      document.getElementById("moveLink").disabled = true;
    }
    document.getElementById("deleteLink").disabled = true;
  }
}


function fnCopy(navigationNode)
{
	if (navigationNode)
	{
		idString = '&startID='+navigationNode;
	}
	else
	{
		idString = '';
	}
	if (arrCheckItem.length > 0) 
	{
		strURL = "pop.navigate.php?action=copyview"+idString+"&items=";
		for(var cnt = 0; cnt < arrCheckItem.length; cnt++) 
		{
			strURL += arrCheckItem[cnt] + ";";
		}
		window.open(strURL, 'structure', 'menubar=no, height=200, width=300');
	}
}


function fnMove(navigationNode) 
{
	if (navigationNode)
	{
		idString = '&startID='+navigationNode;
	}
	else
	{
		idString = '';
	}
	if (arrCheckItem.length > 0) 
	{
		strURL = "pop.navigate.php?action=moveview"+idString+"&items=";
		for(var cnt = 0; cnt < arrCheckItem.length; cnt++) 
		{
			strURL += arrCheckItem[cnt] + ";";
		}
		window.open(strURL, 'structure', 'menubar=no, height=200, width=300');
	}
}


function fnDelete(ID, strConfirmation) {
  if (arrCheckItem.length > 0 && confirm(strConfirmation)) {

    strURL = "frame.content.php?ID=" + ID + "&action=delete&items=";
    for(cnt = 0; cnt < arrCheckItem.length; cnt++) {
      strURL += arrCheckItem[cnt] + ";";
    }
    document.location.href = strURL;
  }
}

function fnDeleteMuujad(strConfirmation) {
  if (arrCheckItem.length > 0 && confirm(strConfirmation)) {

    strURL = "frame.edasimuujad.php?action=delete&items=";
    for(cnt = 0; cnt < arrCheckItem.length; cnt++) {
      strURL += arrCheckItem[cnt] + ";";
    }
    document.location.href = strURL;
  }
}

function fnDeleteTellimused(strConfirmation) {
  if (arrCheckItem.length > 0 && confirm(strConfirmation)) {
	
	if (invoice_payment == 1){
		strURL = "frame.tellimused.php?invoice=1&action=delete&items=";
	}else if(invoice_payment == 2){
		strURL = "frame.tellimused.php?invoice=2&action=delete&items=";
	}else{
    	strURL = "frame.tellimused.php?action=delete&items=";
    }
    for(cnt = 0; cnt < arrCheckItem.length; cnt++) {
      strURL += arrCheckItem[cnt] + ";";
    }
    document.location.href = strURL;
  }
}
function fnDeleteComments(strConfirmation) 
{
	if (arrCheckItem.length > 0 && confirm(strConfirmation)) 
	{
		strURL = "frame.productcomments.php?action=delete&items=";
		for(cnt = 0; cnt < arrCheckItem.length; cnt++) 
		{
			strURL += arrCheckItem[cnt] + ";";
		}
		document.location.href = strURL;
	}
}

function fnSearchbar() {
  objSearchbar = document.getElementById("searchbar");
  objSearchbar.style.display = (objSearchbar.style.display == "none") ? "block" : "none";
}


function fnDeleteTopic(ID, strConfirmation) {

  if (arrCheckItem.length > 0 && confirm(strConfirmation)) {

    strURL = "frame.content.php?ID=" + ID + "&action=topicdelete&items=";
    for(cnt = 0; cnt < arrCheckItem.length; cnt++) {
      strURL += arrCheckItem[cnt] + ";";
    }

    document.location.href = strURL;
  }
}

function naviGo(strLink)
{
    parent.treeframe.location.href = 'frame.tree.php'+strLink;
    parent.contentframe.location.href='frame.content.php'+strLink;
}

function fnDeleteProductVariables(ID, strConfirmation)
{
	if (arrCheckItem.length > 0 && confirm(strConfirmation))
	{
		strURL = "frame.content.php?ID=" + ID + "&action=productvariabledelete&items=";
		for(cnt = 0; cnt < arrCheckItem.length; cnt++)
		{
			strURL += arrCheckItem[cnt] + ";";
		}
		document.location.href = strURL;
	}
}

function fnDeleteFilter(ID, strConfirmation)
{
	if (arrCheckItem.length > 0 && confirm(strConfirmation))
	{
		strURL = "pop.productcatalogpublicfilter.php?parentID=" + ID + "&action=deletefilter&items=";
		for(cnt = 0; cnt < arrCheckItem.length; cnt++)
		{
			strURL += arrCheckItem[cnt] + ";";
		}
		document.location.href = strURL;
	}
}

function fnDeleteProductSubstructure(ID, strConfirmation)
{
	if (arrCheckItem.length > 0 && confirm(strConfirmation))
	{
		strURL = "pop.product.php?ID=" + ID + "&action=substructuredelete&items=";
		for(cnt = 0; cnt < arrCheckItem.length; cnt++)
		{
			strURL += arrCheckItem[cnt] + ";";
		}
		document.location.href = strURL;
	}
}

function fnDeleteProducts(ID, strConfirmation)
{
	if (arrCheckItem.length > 0 && confirm(strConfirmation))
	{
		strURL = "frame.content.php?ID=" + ID + "&action=productsdelete&items=";
		for(cnt = 0; cnt < arrCheckItem.length; cnt++)
		{
			strURL += arrCheckItem[cnt] + ";";
		}
		document.location.href = strURL;
	}
}

function openClose (ID)
{
	var rows = ['r1_' + ID, 'r2_' + ID, 'r3_' + ID];
	var is_opened;
	
	for (var i = 0 ; i < rows.length ; i++)
	{
		if (document.getElementById(rows[i]))
		{
			document.getElementById(rows[i]).style.display = ('none' == document.getElementById(rows[i]).style.display) ? '' : 'none';
			is_opened = ('' == document.getElementById(rows[i]).style.display);
		}
	}
	
	document.getElementById('image_zone_' + ID).src = (is_opened) ? 'images/icons/folderopened.gif' : 'images/icons/folder.gif';
}

