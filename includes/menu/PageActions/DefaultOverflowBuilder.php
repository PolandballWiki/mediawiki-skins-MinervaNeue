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

namespace MediaWiki\Minerva\Menu\PageActions;

use Hooks;
use MediaWiki\Minerva\Menu\Group;
use MessageLocalizer;
use MinervaUI;

class DefaultOverflowBuilder implements IOverflowBuilder {

	/**
	 * @var MessageLocalizer
	 */
	private $messageLocalizer;

	/**
	 * Initialize Default overflow menu Group
	 *
	 * @param MessageLocalizer $messageLocalizer
	 */
	public function __construct( MessageLocalizer $messageLocalizer ) {
		$this->messageLocalizer = $messageLocalizer;
	}

	/**
	 * @inheritDoc
	 */
	public function getGroup( array $toolbox ) {
		$group = new Group();
		$possibleEntries = array_filter( [
			$this->build( 'info', 'info', 'info', $toolbox ),
			$this->build( 'permalink', 'link', 'permalink', $toolbox ),
			$this->build( 'backlinks', 'articleRedirect', 'whatlinkshere', $toolbox ),
			$this->build( 'wikibase', 'logo-Wikidata', 'wikibase', $toolbox ),
			$this->build( 'cite', 'quotes', 'citethispage', $toolbox )
		] );

		foreach ( $possibleEntries as $menuEntry ) {
			$group->insertEntry( $menuEntry );
		}
		Hooks::run( 'MobileMenu', [ 'pageactions.overflow', &$group ] );
		return $group;
	}

	/**
	 * Build the single menu entry
	 *
	 * @param string $name
	 * @param string $icon Wikimedia UI icon name.
	 * @param string $toolboxIdx
	 * @param array $toolbox An array of common toolbox items from the sidebar menu
	 * @return PageActionMenuEntry|null
	 */
	private function build( $name, $icon, $toolboxIdx, array $toolbox ) {
		$href = $toolbox[$toolboxIdx]['href'] ?? null;

		return $href ?
			new PageActionMenuEntry(
				'page-actions-overflow-' . $name,
				$href,
				MinervaUI::iconClass( '', 'before', 'wikimedia-ui-' . $icon . '-base20' ),
				$this->messageLocalizer->msg( 'minerva-page-actions-' . $name )
			) : null;
	}
}
