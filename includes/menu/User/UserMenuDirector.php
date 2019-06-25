<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */
namespace MediaWiki\Minerva\Menu\User;

use MinervaUI;
use TemplateParser;
use MessageLocalizer;

/**
 * Director responsible for building the user menu.
 */
final class UserMenuDirector {
	/**
	 * @var IUserMenuBuilder
	 */
	private $builder;

	/**
	 * @var MessageLocalizer
	 */
	private $localizer;

	/**
	 * @param IUserMenuBuilder $builder
	 * @param MessageLocalizer $localizer
	 */
	public function __construct( IUserMenuBuilder $builder, MessageLocalizer $localizer ) {
		$this->builder = $builder;
		$this->localizer = $localizer;
	}

	/**
	 * Build the menu data array that can be passed to views/javascript
	 * @return string|null
	 */
	public function renderMenuData() {
		$entries = $this->builder->getGroup()->getEntries();

		foreach ( $entries as &$entry ) {
			foreach ( $entry['components'] as &$component ) {
				$component['class'] .= ' toggle-list-item__anchor--menu';
			}
		}

		$templateParser = new TemplateParser( __DIR__ . '/../../../components' );
		return empty( $entries )
			? null
			: $templateParser->processTemplate( 'ToggleList', [
				'class' => 'minerva-user-menu',
				'checkboxID' => 'minerva-user-menu-checkbox',
				'toggleID' => 'minerva-user-menu-toggle', // See minerva.mustache too.
				'toggleClass' => MinervaUI::iconClass(
					'page-actions-overflow', 'element', 'wikimedia-ui-' . 'userAvatar' . '-base20'
				),
				'listClass' => 'minerva-user-menu-list toggle-list__list--drop-down', // See ToggleList/*.less.
				'text' => $this->localizer->msg( 'minerva-user-menu-button' )->escaped(),
				'items' => $entries
			] );
	}
}
