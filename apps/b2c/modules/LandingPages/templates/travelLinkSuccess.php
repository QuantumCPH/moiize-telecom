<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<center>
<h1>The Gif Banners</h1>
</center>

<br/>
<h3>High Resolution Image - (with link)</h3>
<br/>
<a href="http://test.zerocall.com/b2c_dev.php/LandingPages/window">
<?php echo image_tag('/zerocall/images/banner_gif_high_res.gif','width=600','border=0') ?>
</a>
<br/>
<br />
<br/>
<br />
 <a href="/b2c_dev.php/LandingPages/B2B?bid=<?php echo $_GET['bid']?>&hid=<?php echo $_GET['hid']?>">B2B</a>
 <a href="/b2c_dev.php/customer/signup?bid=<?php echo $_GET['bid']?>&hid=<?php echo $_GET['hid']?>">B2C</a>

