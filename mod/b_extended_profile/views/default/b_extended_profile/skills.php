<?php
$user_guid = elgg_get_page_owner_guid();
$user = get_user($user_guid);

// if skills isn't empty, display them so that the user can use them as a guide
if ($user->skills != NULL && $user->skillsupgraded == NULL) {
    echo '<div class="gcconnex-old-skills">';
    echo '<div class="gcconnex-old-skills-message">You have previously entered skills which may need to be re-entered in the system. Please review your previously entered skills below and re-enter them as needed. When entering or re-entering a skill, <b>please make sure they are actual  skills that you believe you possess, that they are specific, professional and that they provide viewers of your profile with clear, meaningful and useful information</b> (ie: Not "A bunch of things.. " or "Getting things done!").</div>';
    echo '<div class="gcconnex-old-skills-display">';

    if (is_array($user->skills)) {
        foreach ($user->skills as $oldskill)
        echo $oldskill . '<br>';
    }

    echo '</div><br>'; // close div class="gcconnex-old-skills-display
    echo '<span class="gcconnex-old-skills-stop-showing gcconnex-profile-button" onclick="removeOldSkills()">Stop showing me this message.</span>';
    echo '</div>'; // close div class="gcconnex-old-skills"
}

$skill_guids = $user->gc_skills;

echo '<div class="gcconnex-profile-skills-display">';
echo '<div class="gcconnex-skills-skills-list-wrapper">';

if ($skill_guids == NULL || empty($skill_guids)) {
    echo elgg_echo('gcconnex_profile:gc_skill:empty') . '</div></div>';
}
else {
    if (!(is_array($skill_guids))) {
        $skill_guids = array($skill_guids);
    }
}

// if the skill list isn't empty, and a logged-in user is viewing this page... show skills
if (is_array($skill_guids) && elgg_is_logged_in()) {
    foreach($skill_guids as $skill_guid) {
        $skill = get_entity($skill_guid);
        $skill_class =  str_replace(' ', '-', strtolower($skill->title));
        echo '<div class="gcconnex-skill-entry" data-guid="' . $skill_guid . '">';
            echo '<div class="gcconnex-endorsements-count gcconnex-endorsements-count-' . $skill_class . '">' . count($skill->endorsements) . '</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';

        $endorsements = $skill->endorsements;
        if(!(is_array($endorsements))) { $endorsements = array($endorsements); }

            if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
                if(in_array(elgg_get_logged_in_user_guid(), $endorsements) == false || empty($endorsements)) {
                    // user has not yet endorsed this skill for this user.. present the option to endorse
                    error_log('SKILL: ' . $skill->title);
                    error_log('Logged in user: ' . elgg_get_logged_in_user_guid());
                    error_log('Endorsements: ' . $endorsements);
                    error_log('Search result: ' . in_array(elgg_get_logged_in_user_guid(), $endorsements));

                    echo '<span class="gcconnex-endorsement-add add-endorsement-' . $skill_class . '" onclick="addEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">+</span>';
                }
                else {
                    // user has endorsed this skill for this user.. present the option to retract endorsement
                    echo '<span class="gcconnex-endorsement-retract retract-endorsement-' . $skill_class . '" onclick="retractEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">-</span>';
                    error_log('SKILL: ' . $skill->title);
                    error_log('Logged in user: ' . elgg_get_logged_in_user_guid());
                    error_log('Endorsements: ' . $endorsements);
                    error_log('Search result: ' . in_array(elgg_get_logged_in_user_guid(), $endorsements));
                }
            }
        // @todo: add the endorsing user's profile image to the list of endorsers for this skill
        echo '</div>'; // close div class=gcconnex-skill-entry
    }
    echo '</div>';  // close div class=gcconnex-endorsements-skills-list-wrapper
    echo '</div>'; // close div class=gcconnex-profile-endorsements-display
}
else {


    /*

    $skill = get_entity($skill_guids);
//    $skillClass = str_replace(" ", "-", strtolower($skill->title));
    echo '<div class="gcconnex-skill-entry" data-guid="' . $skill_guids . '">';
        echo '<div class="gcconnex-endorsements-count">0</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';
    echo '</div>';
    */
}

//echo '</div></div><div class="endorsements-message"></div>';
