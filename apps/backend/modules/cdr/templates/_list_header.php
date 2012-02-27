<?php $unmatchedRecordsCount =  count(CdrLogPeer::getAllUnmatchedRecords());

?>
<div class="errorbox">
<?php
if ($unmatchedRecordsCount > 0) 
{ ?>
	There are <?php echo $unmatchedRecordsCount ?> record(s) in this log,
	that havn't matched with our internal system.
	
	You can try the following.
	<ul>
		<?php  $missingDestinationsCount = count(CdrLogPeer::getMissingDestinations()); 
			if ($missingDestinationsCount>0) {
		?>
				<li><a href="<?php echo url_for('cdr/createMissingDestinations'); ?>">Create <?php echo $missingDestinationsCount ?> missing destinations</a>
				-- could fix upto <?php echo count(CdrLogPeer::getMissingDestinations(false)) ?> record(s)</li>
				<li>Set rates to new destinations</li>
		<? } ?>
		<?php  $emptyDestinationCount = count(CdrLogPeer::getEmptyDestinations()); 
			if ($emptyDestinationCount>0) {
		?>
				<li>Set a valid description value to <b><?php echo $emptyDestinationCount ?> empty destinations</b></li>
		<? } ?>
		<?php  $unmatchedEmployeesCount = count(CdrLogPeer::getUnmatchedEmployees()); 
			if ($unmatchedEmployeesCount>0) {
		?>
				<li>Create <b><?php echo  $unmatchedEmployeesCount ?> missing employees</b> and assign them a company
				-- could fix upto <?php echo count(CdrLogPeer::getUnmatchedEmployees(false)) - $emptyDestinationCount ?> record(s)</li>
		<? } ?>
		<li>&nbsp;</li>
		<li><a href="<?php echo url_for('cdr/reprocess') ?>">Reporcess unmatched records</a></li>
<?php 
}

$suspectedRecordsCount = count(CdrLogPeer::getSuspectedRecords());

if ($suspectedRecordsCount > 0) {
?>
		<li><a href="<?php echo url_for('cdr/reprocessSuspects') ?>">Reprocess <?php echo count(CdrLogPeer::getSuspectedRecords()) ?> suspects</a> i.e. profit &lt;= 0</li>
<?php } ?>
	</ul>
</div>