<?php

	$episode = Nexus_Episode::factory(); // whatever is in the loop
	$people = $episode->get_people();

	// var_dump($people);

	$primary = array_merge($people['hosts'], $people['primary']);
	$secondary = $people['secondary'];

?>

<div class="people">
	<div class="box">
	
		<?php if ( count($primary) > 0 ): ?>
		<h4>In This Episode</h4>
		<div class="primary-people">
			
			<?php
				foreach ($primary as $person_id):
				$person = Nexus_Person::factory($person_id);
				$cp_person = new Coprime_Person($person);
			?>
			<div class="person">
				
				<?php
					echo $cp_person->get_avatar(50);
					echo $cp_person->get_formatted_name();
				?>
				
			</div>
			<?php endforeach; ?>
			
		</div>
		<?php endif; ?>

		<?php if ( count($secondary) > 0 ): ?>
		<div class="secondary-people">
			
			<?php
				$people = array();
				foreach ($secondary as $person_id):
				$person = Nexus_Person::factory($person_id);
				$cp_person = new Coprime_Person($person);
				$people[] = $cp_person->get_formatted_name('span');
				endforeach;
			?>
			
			<p class="and-also"><span>Also with: </span><?php echo Nexus_Core::human_list($people) ?></p>
			
		</div>
		<?php endif; ?>

	</div>
</div>