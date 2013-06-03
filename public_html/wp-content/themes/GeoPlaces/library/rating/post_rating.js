post_rating_max = POSTRATINGS_MAX;
function current_rating_star_on(post_id, rating, rating_text) {
	
	for(i=1;i<=post_rating_max;i++)
	{
		document.getElementById('rating_' + post_id + '_' + i).src = RATING_IMAGE_OFF;
	}
	for(i=1;i<=rating;i++)
	{
		document.getElementById('rating_' + post_id + '_' + i).src = RATING_IMAGE_ON;
	}
	document.getElementById('ratings_' + post_id + '_text').innerHTML = rating_text;
	document.getElementById('post_' + post_id + '_rating').value = rating;
}

function current_rating_star_off(post_id, rating) {
}

