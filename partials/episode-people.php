<?php

	$episode = Nexus_Episode::factory(); // whatever is in the loop
	$people = $episode->get_people();
	$cp_episode = new Coprime_Episode($episode);

	$primary = array_merge($people['hosts'], $people['primary']);
	$secondary = $people['secondary'];

?>

<div class="people">
	<div class="box">
	
		<?php if ( count($primary) > 0 ): ?>
		<h4>In This Episode</h4>
		<div class="primary-people">
			<ul>

			<?php
				foreach ($primary as $person_id):
				$person = Nexus_Person::factory($person_id);
				$cp_person = new Coprime_Person($person);
			?>
			
			<li>
				<div class="person">
					<?php
						echo $cp_person->get_avatar(150);
						echo $cp_person->get_formatted_name();
					?>
				</div>
			</li>

			<?php endforeach; ?>

			</ul>
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
			
			<p class="and-also"><span>Also with: </span><?php echo Nexus_Utility::human_list($people) ?></p>
			
		</div>
		<?php endif; ?>

		<p class="forward-contact"><?php echo $cp_episode->get_contact_link(); ?></p>

	</div>
</div>