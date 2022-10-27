// Post Type and Taxonomy Order
(function ($)
{
	// Media
	$("#adminify-pto-media #sortable").sortable({
		'tolerance': 'intersect',
		'cursor': 'pointer',
		'items': 'li',
		'axis': 'y',
		'placeholder': 'placeholder',
		'nested': 'ul',
		'update': function (e, ui){
			$.post(ajaxurl, {
				action: 'update_post_types_order',
				order: $("#adminify-pto-media #sortable").sortable("serialize"),
				'adminify_media_sort_nonce': $('#adminify_media_sort_nonce').val()
			}, function() {
				$("#adminify-ajax-response").html('<div class="message updated"><p>Media Order Updated</p></div>');
				$("#adminify-ajax-response div").delay(2000).hide("slow");
			});
		}
	});

	// $("#sortable").disableSelection();


	// posts
	$('table.posts #the-list, table.pages #the-list, table.media #the-list').sortable({
		'items': 'tr',
		'axis': 'y',
		'helper': adminifyPTOHelper,
		'update': function (e, ui)
		{
			$.post(ajaxurl, {
				action: 'update_post_types_order',
				order: $('#the-list').sortable('serialize'),
			});
		}
	});
	//$("#the-list").disableSelection();

	// Taxonomy Order
	$('table.tags #the-list').sortable({
		'items': 'tr',
		'axis': 'y',
		'helper': adminifyPTOHelper,
		'update': function (e, ui)
		{
			$.post(ajaxurl, {
				action: 'update_post_types_taxonomy_order',
				order: $('#the-list').sortable('serialize'),
			});
		}
	});
	//$("#the-list").disableSelection();

	/* <fs_premium_only> */
	// sites
	var site_table_tr = $('table.sites #the-list tr');
	site_table_tr.each(function (){
		var ret = null;
		var url = $(this).find('td.blogname a').attr('href');
		parameters = url.split('?');
		if (parameters.length > 1)
		{
			var params = parameters[1].split('&');
			var paramsArray = [];
			for (var i = 0; i < params.length; i++)
			{
				var neet = params[i].split('=');
				paramsArray.push(neet[0]);
				paramsArray[neet[0]] = neet[1];
			}
			ret = paramsArray['id'];
		}
		$(this).attr('id', 'site-' + ret);
	});
	/* </fs_premium_only> */

	$('table.sites #the-list').sortable({
		'items': 'tr',
		'axis': 'y',
		'helper': adminifyPTOHelper,
		'update': function (e, ui)
		{
			$.post(ajaxurl, {
				action: 'update_post_types_order_sites',
				order: $('#the-list').sortable('serialize'),
			});
		}
	});

	var adminifyPTOHelper = function (e, ui)
	{
		ui.children().children().each(function ()
		{
			$(this).width($(this).width());
		});
		return ui;
	};

})(jQuery)
