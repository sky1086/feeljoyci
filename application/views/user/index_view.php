<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>FeelJoy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
</head>
<body>
<script>
var d_width = document.documentElement.clientWidth;
if(d_width < 700){
document.write('<img src="<?php echo base_url()?>/img/m_comingsoon.png" style="width:100%"/>');
}else{
document.write('<img src="<?php echo base_url()?>/img/comingsoon.png" style="width:100%"/>');
}
</script>
</body>

</html>
