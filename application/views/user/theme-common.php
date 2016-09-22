<script src="<?php echo base_url();?>js/custom.js"></script>
<script>
    var colorTh = getColorTheme();
	if(colorTh != ''){
		document.write('<link rel="stylesheet" href="<?php echo base_url();?>css/themes/' + colorTh + '.css">');
	}else{
		document.write('<link rel="stylesheet" href="<?php echo base_url();?>css/themes/t0.css">');
		}
    </script>