<html>
<head>
<title> Agent Flash Banner Demo</title>
</head>
<body>
    <center>
    <h2>  Agent Flash Banner Demo </h2>
    </center>
<br/>
<ul style="list-style-type:circle">
        <li>When you will click this banner, you will be taken to the sign-up page</li><br/><br/>
        <li>There will be Agents ID inserted in the link (at the end of URL i.e. ?ref=3)</li><br/><br/>
        <li>Hence when you signup, the referred ID (agent's id will be saved along with customer</li><br/><br/>
        <li>This will enable us to provide commission to the agent.</li><br/><br/>
        <li>Currently there is a link for Agent # 3, i.e. LandNCall AB</li><br/><br/>
</ul>
<br/>
<h4>  Agent banner with embedded link: </h4>
<object width="790" height="120">
<param name="movie" value="bwb"></param>
<param name="allowFullScreen" value="true"></param>
<param name="allowscriptaccess" value="always"></param>
<embed src="<?php echo _compute_public_path('banner_3','zerocall/swf','swf')?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="790" height="120">
</embed>
</object>
<br/>
<br/>

<br/>
</body>

</html>