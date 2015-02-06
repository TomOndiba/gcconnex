<?php
if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}
else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);
$work_experience_guid = $user->work;

if ($work_experience_guid == NULL || empty($work_experience_guid)) {
    echo elgg_echo('gcconnex_profile:experience:empty') . '</div></div>';
}
else {
    if (!(is_array($work_experience_guid))) {
        $work_experience_guid = array($work_experience_guid);
    }
}

if (is_array($work_experience_guid)) {

    usort($work_experience_guid, "sortDate");

        foreach ($work_experience_guid as $guid) {

        $experience = get_entity($guid);

        echo '<div class="gcconnex-profile-work-experience-display gcconnex-work-experience-' . $experience->guid . '">';
        echo '<div class="gcconnex-profile-label work-experience-dates">' .$experience->startdate . ', ' . $experience->startyear . ' - ';
        if ($experience->ongoing == 'true') {
            echo elgg_echo('gcconnex_profile:experience:present');
        }
        else {
            echo $experience->enddate . ', ' . $experience->endyear;
        }
        echo '</div>';
        echo '<div class="gcconnex-profile-label work-experience-title">' . $experience->title . '</div>';
        echo '<div class="gcconnex-profile-label work-experience-organization">' . $experience->organization . '</div>';
        echo '<div class="gcconnex-profile-label work-experience-responsibilities">' . $experience->responsibilities . '</div>';
        echo '</div>';
    }
}