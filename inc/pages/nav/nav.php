<?php
if(!isset($id))$id=-1;
if(!isset($links))$links=[0=>["url"=>"index.php","name"=>"Home","right"=>false]];
?>
<nav>
	<?php
		foreach($links as $k => $value){
			if($k==$id){
				echo '<span class="active'.($value["right"]?" right":"").'">'.$value["name"].'</span>';
			}else{
				echo '<a href="'.$value["url"].'"'.($value["right"]?" class=right":"").'>'.$value["name"].'</a>';
			}
		}
	?>
</nav>