<!DOCTYPE html>
<head>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title></title>
</head>
<body>

<script>
  	var url = window.location;
  	var hash = $(location).attr('hash');
  	var params = { 
  		client_id:10, 
  		redirect_uri:'http://192.168.1.94/js_app/single_page_js_app.php',
  		response_type:'token',
  		scope:'',
  	};
	var str = jQuery.param( params );

	jQuery(document).ready(function()
	{	
		if(hash == '')
		{
			window.location.replace('http://192.168.1.94:8000/oauth/authorize?' + str);
		}
		else
		{
			access_token = getParameterByName('access_token', hash);			
			
			// Method 1 : Using xmlHttpRequest
			function testingImplicitGrantApi()
			{ 
			    var key = access_token; 
			    var url = "http://192.168.1.94:8000/api/todos";
			    console.log(httpGet(url,key)); 
			}

			function httpGet(url,key)
			{
			    var xmlHttp = new XMLHttpRequest();
			    xmlHttp.open( "GET", url, false );
			    xmlHttp.setRequestHeader("Authorization",'Bearer ' + key);
			    //xmlHttp.setRequestHeader("Access-Control-Allow-Origin",'*');
			    xmlHttp.send(null);
			    return xmlHttp.responseText;
			}

			testingImplicitGrantApi();

			// Method 2 : Using Ajax
			$.ajax({
	  			type : 'GET',
	  			url : 'http://192.168.1.94:8000/api/todos',	  			
	  			headers:{
	  				'Authorization': 'Bearer ' + access_token,
	  			},  			
	  			success: function(response){
			        console.log(response);
			    },
			    error: function(jqXHR, textStatus, errorThrown){
			        console.log('jqXHR:');
	                console.log(jqXHR);
	                console.log('textStatus:');
	                console.log(textStatus);
	                console.log('errorThrown:');
	                console.log(errorThrown);
			    }
	  		});
		}		

		function getParameterByName(name, url) 
		{
		    if (!url) url = window.location.href;
		    name = name.replace(/[\[\]]/g, "\\$&");
		    var regex = new RegExp("[#&]" + name + "(=([^&#]*)|&|#|$)"),
		        results = regex.exec(url);
		    if (!results) return null;
		    if (!results[2]) return '';
		    return decodeURIComponent(results[2].replace(/\+/g, " "));
		}	
  	});  	
</script>
</body>
</html>