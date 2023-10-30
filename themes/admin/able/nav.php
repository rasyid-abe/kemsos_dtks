<?php

class Navigasi {

	public function crete_menu() {

		$arr_menu = $_SESSION['user_menu'];
		$menu = '';
		$menu .= '<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">';
		$menu .= $this->render_nav( $arr_menu, '0' );
		$menu .= '</ul>';
		return $menu;
	}

	public function render_nav( $arr_menu = [], $parent_id = '0' ) {
		$generate_menu = '';
		if ( array_key_exists( $parent_id, $arr_menu ) ) {
			ksort( $arr_menu[$parent_id] );
			foreach ( $arr_menu[$parent_id] as $rootmenu_sort => $rootmenu_value ) {
				$have_child = array_key_exists( $rootmenu_value['menu_id'], $arr_menu );
				if ( $have_child ) {
					$rootmenu_link = 'javascript:;';
				} else {
					if ( $rootmenu_value['menu_url'] == '#' ) {
						$rootmenu_link = '#';
					} else {
						$rootmenu_link = base_url() . $rootmenu_value['menu_url'];
					}
				}
				if ( $parent_id == 0 ) {
					$generate_menu .= '
						<li class="nav-item">
						<span class="nav-link">
							<i class="' . $rootmenu_value['menu_class'] . '"></i>
							<b class="menu-title" style="color:#4680ff; font-weight:600" data-i18n="' . $rootmenu_value['menu_name'] . '">' . $rootmenu_value['menu_name'] . '</b>
						</span>
						</li>
					';
				} else {
					if ($rootmenu_value['menu_class'] != "") {
						$onn = "";
						$uri = $_SERVER['REQUEST_URI'];
						if(substr($uri, 1) == $rootmenu_value['menu_url']){
							$onn = "active";
						} else $onn = "";						

						$generate_menu .= '
							<li class="nav-item ' . $onn . ' ' . ( ( $have_child ) ? 'has-sub' : '' ) . '" title="' . $rootmenu_value['menu_description'] . '">
								<a href="' . $rootmenu_link . '" class="nav-link" data-toggle="tooltip" data-placement="right" title="' . $rootmenu_value['menu_name'] . '">
									<i class="' . $rootmenu_value['menu_class'] . '"></i>
									<span class="menu-title" data-i18n="' . $rootmenu_value['menu_name'] . '">' . $rootmenu_value['menu_name'] . '</span>
								</a>
						';
					} else {
						$generate_menu .= '
							<li class="nav-item ' . ( ( $have_child ) ? 'has-sub' : '' ) . '" title="' . $rootmenu_value['menu_description'] . '">
								<a href="' . $rootmenu_link . '" class="nav-link">
									<span class="menu-title" data-i18n="' . $rootmenu_value['menu_name'] . '">' . $rootmenu_value['menu_name'] . '</span>
								</a>
						';
					}
				}
				if ( $have_child ) {
					if ( $parent_id == 0 ) {
						$generate_menu .= $this->render_nav( $arr_menu, $rootmenu_value['menu_id'] );
					}
					elseif ( $parent_id != 0 ) {
						$generate_menu .= '<ul class="menu-content">';
						$generate_menu .= $this->render_nav( $arr_menu, $rootmenu_value['menu_id'] );
						$generate_menu .= '</ul>';
					}
				}
				$generate_menu .= ( ( $parent_id == 0 ) ? '' : '</li>' );
			}
		}
		return $generate_menu;
	}
}
$nav = new Navigasi();
echo $nav->crete_menu();
?>
