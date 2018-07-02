<?phpdefined( 'ABSPATH' ) or die();session_start();get_header();while (have_posts()) : the_post();    $wp_voting_item_names = get_post_meta(get_the_id(), 'wp_voting_contest_item', true);    $wp_voting_item_imgs = get_post_meta(get_the_id(), 'wp_voting_contest_item_img', true);    $wp_voting_item_descs = get_post_meta(get_the_id(), 'wp_voting_contest_item_desc', true);    $wp_voting_item_subtitles = get_post_meta(get_the_id(), 'wp_voting_contest_item_subtitle', true);    $wp_voting_contest_start_date = (int)strtotime(get_post_meta(get_the_id(), 'wp_voting_contest_start_date', true));    $wp_voting_contest_end_date = (int)strtotime(get_post_meta(get_the_id(), 'wp_voting_contest_end_date', true));    $wp_voting_contest_item_id = get_post_meta(get_the_id(), 'wp_voting_contest_item_id', true);    $wp_voting_contest_vote_total_count = (int)get_post_meta(get_the_id(), 'wp_voting_vote_total_count', true);    $wp_voting_actual_date = (int)date_timestamp_get(new DateTime());    // IDENTIFICATION BY IP    $wp_voting_contest_ip_users = get_post_meta(get_the_id(), 'wp_voting_contest_ip_users', true);    $ip_user = $_SERVER['REMOTE_ADDR'];    $str .= '<div class="wp_voting_container wp_voting_contest-id wp_voting_contest-' . get_the_id() . '">	<h1 class="wp_voting_title"><span>' . get_the_title() . '</span></h1>	<div class="wp_voting_grid wp_voting_survey-stage">';    if ($wp_voting_actual_date >= $wp_voting_contest_end_date) {        $str .= '<span class="wp_voting_stage wp_voting_ended wp_voting_active">Votes clos</span>';    } elseif ($wp_voting_contest_start_date >= $wp_voting_actual_date) {        $str .= '<span class="wp_voting_stage wp_voting_ended wp_voting_active">Votes bientôt ouverts</span>';        // IDENTIFICATION BY COOKIES        //} elseif(isset($_COOKIE['wp_voting_id-'.get_the_id()]) && $_COOKIE['wp_voting_id-'.get_the_id()] == get_the_id()) {        // $str .= '<span class="wp_voting_stage wp_voting_ended wp_voting_active">Vous avez déjà voté pour cette catégorie</span>';        //}        // IDENTIFICATION BY IP    } else {        if ($wp_voting_contest_ip_users) {            foreach ($wp_voting_contest_ip_users as $wp_voting_contest_ip_user) {                if ($wp_voting_contest_ip_user == $ip_user) {                    $str .= '<span class="wp_voting_stage wp_voting_ended wp_voting_active">Vous avez déjà voté pour cette catégorie</span>';                }            }        }    }    $str .= '</div>	<div class="wp_voting_inner">	<ul class="wp_voting_surveys wp_voting_grid">';    $n = 1;    $i = 0;    foreach ($wp_voting_item_names as $wp_voting_item_name) {        $str .= ' <li class="wp_voting_survey-item">		<div class="wp_voting_survey-item-inner">';        if ($wp_voting_item_imgs[$i]) {            $str .= '<div class="wp_voting_survey-country" style="background-image:url(' . $wp_voting_item_imgs[$i] . ')">';            $str .= '</div>';        }        $str .= '<div class="wp_voting_survey-box-under">		<div class="wp_voting_infos">		<div class="wp_voting_survey-name">		' . $wp_voting_item_name . '		</div>		<div class="wp_voting_survey-subtitle">' . $wp_voting_item_subtitles[$i] . '</div>';        $str .= '<div class="wp_voting_survey-extract">' . wp_voting_item_synopsis($wp_voting_item_descs[$i]) . '</div>		</div>';        if ($wp_voting_contest_start_date <= $wp_voting_actual_date && $wp_voting_actual_date <= $wp_voting_contest_end_date) {            $str .= '<div class="wp_voting_survey-item-action"> ';            $str .= '<div class="wp_voting_item-action wp_voting_survey-profil">			<button data-open="profil-' . get_the_id() . $n . '" class="wp_voting_button wp_voting_survey-profil-button">Voir le profil</button></div>';            // IDENTIFICATION BY IP            if ($wp_voting_contest_ip_users) {                foreach ($wp_voting_contest_ip_users as $wp_voting_contest_ip_user) {                    if ($wp_voting_contest_ip_user == $ip_user)                        $vote_registred = true;                }            }            if ($vote_registred !== true) {                $str .= '<form action="" name="" class="wp_voting_survey-item-action-form wp_voting_item-action">				<input type="hidden" name="wp_voting_contest-id" id="wp_voting_contest-id" value="' . get_the_id() . '">				<input type="hidden" name="wp_voting_survey-item-id" id="wp_voting_survey-item-id" value="' . $wp_voting_contest_item_id[$i] . '">				<input type="button" class="wp_voting_button" name="wp_voting_survey-vote-button-' . get_the_id() . $n . '" id="wp_voting_survey-vote-button" value="Je vote">				</form>				</div>';                // IDENTIFICATION BY COOKIES                // if (!isset($_COOKIE['wp_voting_id-'.get_the_id()]) || $_COOKIE['wp_voting_id-'.get_the_id()] != get_the_id()) {                //  $str .= '<form action="" name="" class="wp_voting_survey-item-action-form">                //  <input type="hidden" name="wp_voting_contest-id" id="wp_voting_contest-id" value="' . get_the_id() . '">                //  <input type="hidden" name="wp_voting_survey-item-id" id="wp_voting_survey-item-id" value="' . $wp_voting_contest_item_id[$i] . '">                //  <input type="button" class="wp_voting_button" name="wp_voting_survey-vote-button-' . get_the_id().$n . '" id="wp_voting_survey-vote-button" value="Je vote">                //  </form>                //  </div>';            } else {                $str .= '</div>';            }        } else {            $str .= '<div class="wp_voting_survey-item-action">			<div class="wp_voting_item-action wp_voting_survey-profil">			<button data-open="profil-' . get_the_id() . $n . '" class="wp_voting_button wp_voting_survey-profil-button">Voir le profil</button>			</div>			</div>';        }        $str .= '		<div class="wp_voting_pop-in">		<div class="wp_voting_modal wp_voting_contest-' . get_the_id() . '" id="profil-' . get_the_id() . $n . '">		<button class="wp_voting_modal-close-button" data-close aria-label="Close modal" type="button">		<span aria-hidden="true">&times;</span>		</button>		<div class="wp_voting_modal-item">		<div class="wp_voting_modal-item-inner">';        if ($wp_voting_item_imgs[$i]) {            $str .= '<div class="wp_voting_modal-container-img">			<div class="wp_voting_modal-img" style="background-image:url(' . $wp_voting_item_imgs[$i] . ')">			</div>			</div>			<div class="wp_voting_modal-content">';        } else {            $str .= '<div class="wp_voting_modal-content">';        }        $str .= '<h1 class="wp_voting_modal-title">' . $wp_voting_item_name . '</h5>		<h2 class="wp_voting_modal-subtitle">' . $wp_voting_item_subtitles[$i] . '</h2>';        $str .= '<p class="wp_voting_modal-description">' . $wp_voting_item_descs[$i] . '</p>';        if ($wp_voting_contest_start_date <= $wp_voting_actual_date && $wp_voting_actual_date <= $wp_voting_contest_end_date) {            // IDENTIFICATION BY COOKIES            // $str .= '<button id="votin" class="wp_voting_button-modal';            // if (isset($_COOKIE['wp_voting_id-'.get_the_id()]) && $_COOKIE['wp_voting_id-'.get_the_id()] == get_the_id())            //     $str .= ' wp_voting_survey-item-action-disabled';            // IDENTIFICATION BY IP            if ($wp_voting_contest_ip_users) {                foreach ($wp_voting_contest_ip_users as $wp_voting_contest_ip_user) {                    if ($wp_voting_contest_ip_user == $ip_user)                        $vote_registred = true;                }            }            if ($vote_registred !== true)                $str .= '<button id="votin" class="wp_voting_button-modal" data-rel="' . get_the_id() . $n . '">Je vote pour ce candidat</button>';        }        $str .= '</div>		</div>		</div>		</div>		</div>';        $str .= '		</div>		</div>		</li>';        if ($n !== 3)            $str .= '<img class="wp_voting_separator" src="/wp-content/themes/nextiawp/assets/img/filet_dore.png" alt="Séparateur" width="1" height="212">';        $i++;        $n++;    };    $str .= '</ul>  	</div>	<div class="wp_voting_processing">En cours..</div>	<div class="wp_voting_fail">Vous avez déjà voté pour cette catégorie</div>	<div class="wp_voting_success">Merci, votre vote a bien été enregistré</div>	</div>	</div>	</div>';endwhile;get_footer();?>