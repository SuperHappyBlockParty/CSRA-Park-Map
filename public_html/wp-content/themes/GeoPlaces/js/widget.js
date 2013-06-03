function claimer_showdetail(str)
{	
	if(document.getElementById('comments_'+str).style.display == 'block')	{
		document.getElementById('comments_'+str).style.display = 'none';
	} else {
		document.getElementById('comments_'+str).style.display = '';
	}
}

