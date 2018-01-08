<!--
if (document.getElementById("listDiv"))
{
    document.getElementById("listDiv").onmouseover = function(e)
    {
        obj = Utils.srcElement(e);
        if (obj)
        {
            if (obj.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode;
            else if (obj.parentNode.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode.parentNode;
            else return;

            for (i = 0; i < row.cells.length; i++)
            {
                if (row.cells[i].tagName != "TH") row.cells[i].style.backgroundColor = '#E2EFF0';
            }
        }
    }

    document.getElementById("listDiv").onmouseout = function(e)
    {
        obj = Utils.srcElement(e);

        if (obj)
        {
            if (obj.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode;
            else if (obj.parentNode.parentNode.tagName.toLowerCase() == "tr") row = obj.parentNode.parentNode;
            else return;

            for (i = 0; i < row.cells.length; i++)
            {
                if (row.cells[i].tagName != "TH") row.cells[i].style.backgroundColor = '#FFFFFF';
            }
        }
    }    
}
//-->