<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Just Little 'ol me</title>
		<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
		<script type="text/javascript">
			$( document ).ready(function() {
				console.log( "je suis prest!" );
				$("body").append("<p>bon jour</p>");
				for(var i=0; i < 10; i++)
				{
					$.ajax({
						type: "POST",
						url: "https://bootcamp-coders.cnm.edu/classmaterials/week3/mvc/controller-post.php",
						data: {
							profileId: "1",
							tweetContent: "Je supposé maintenant je suis un escroc.."
						},
						success: function(){
							console.log("With a little help from my friend...");
						}
// dataType: dataType
					});
				}

			});
			$


		</script>
	</head>
	<body>

	</body>
</html>
