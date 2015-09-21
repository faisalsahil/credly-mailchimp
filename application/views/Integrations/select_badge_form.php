 <style type="text/css">
.dataTables_info{margin-left: 30px;}
.dataTables_length label {margin-left: 30px;}
.dataTables_filter input {margin-left: 9px;}
 </style>

 <table  cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-hover" style="font-size:12px;" id="tt_SB">
 	<thead>
 		
 		<th style="width:1px;"></th>
 		<th style="width:1px;">Badge</th>
 		<th>Title</th>
 		<th>Short Description</th>
 		<th>ID</th>
 		
 	</thead>   
 	<tbody>
 		<?php for($x=0;$x<$count1; $x++){  ?> 
 		<tr>
 			<td><input type="radio" name="optionsRadiosBadge" id="optionsRadiosBadge" alt="<?php echo $badges1[$x]->title; ?>"  value="<?php echo $badges1[$x]->id; ?>" src="<?php echo $badges1[$x]->image_url; ?>"></td>
 			<td><img src=<?php echo $badges1[$x]->image_url; ?> alt="Credly Badge" height="42" width="42"/> </td>
 			<td><strong><?php echo $badges1[$x]->title; ?></strong></td>
 			<td><?php echo $badges1[$x]->short_description; ?></td>
 			<td><?php echo $badges1[$x]->id; ?></td>
 		
 		</tr>
 		<?php } ?>
 	</tbody>
 </table>

 <script type="text/javascript">
$(document).ready(function() {
    $('#tt_SB').dataTable( {
        "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
    } );
} );

 </script>