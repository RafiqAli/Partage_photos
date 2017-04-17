
<script type="text/javascript">

//Rating system By Yassir

	$(document).ready(function() {


	$("#star5").click(function(event) {
			
		for(var i=1; i<=5; i++)
		{
			if(i<=5)
			{
				$("#star"+i).css('color', '#fcd40a');
				$("#star"+i).text("★");
			}else
			{
				$("#star"+i).css('color', '#000');
				$("#star"+i).text("☆");
			}
		}

	});

	$("#star4").click(function(event) {
			
		$("#result").text("4");
		
		for(var i=1; i<=5; i++)
		{
			if(i<=4)
			{
				$("#star"+i).css('color', '#fcd40a');
				$("#star"+i).text("★");
			}else
			{
				$("#star"+i).css('color', '#000');
				$("#star"+i).text("☆");
			}
		}

	});

	$("#star3").click(function(event) {
			
		$("#result").text("3");

		for(var i=1; i<=5; i++)
		{
			if(i<=3)
			{
				$("#star"+i).css('color', '#fcd40a');
				$("#star"+i).text("★");
			}else
			{
				$("#star"+i).css('color', '#000');
				$("#star"+i).text("☆");
			}
		}

	});

	$("#star2").click(function(event) {
			
		$("#result").text("2");

		for(var i=1; i<=5; i++)
		{
			if(i<=2)
			{
				$("#star"+i).css('color', '#fcd40a');
				$("#star"+i).text("★");
			}else
			{
				$("#star"+i).css('color', '#000');
				$("#star"+i).text("☆");
			}
		}
		
	});

	$("#star1").click(function(event) {
			
		$("#result").text("1");

		for(var i=1; i<=5; i++)
		{
			if(i<=1)
			{
				$("#star"+i).css('color', '#fcd40a');
				$("#star"+i).text("★");
			}else
			{
				$("#star"+i).css('color', '#000');
				$("#star"+i).text("☆");
			}
		}

	});

	});

</script>

<style type="text/css" media="screen">

	.rating {
	  unicode-bidi: bidi-override;
	  direction: rtl;
	  font-size: 2em;
	}
	.rating > span {
	  display: inline-block;
	  position: relative;
	  width: .5em;
	}
	.rating > span:hover:before,
	.rating > span:hover ~ span:before {
	   content: "\2605";
	   position: absolute;
	   color: #fcd40a;
	}

</style>


<span class="rating">
	<span id="star5">☆</span>
	<span id="star4">☆</span>
	<span id="star3">☆</span>
	<span id="star2">☆</span>
	<span id="star1">☆</span>
</span>
<br>
<span>Votre note:</span> <span id="result">0</span>
