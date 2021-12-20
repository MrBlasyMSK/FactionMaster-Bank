<?php

/*
 *
 *      ______           __  _                __  ___           __
 *     / ____/___ ______/ /_(_)___  ____     /  |/  /___ ______/ /____  _____
 *    / /_  / __ `/ ___/ __/ / __ \/ __ \   / /|_/ / __ `/ ___/ __/ _ \/ ___/
 *   / __/ / /_/ / /__/ /_/ / /_/ / / / /  / /  / / /_/ (__  ) /_/  __/ /
 *  /_/    \__,_/\___/\__/_/\____/_/ /_/  /_/  /_/\__,_/____/\__/\___/_/
 *
 * FactionMaster - A Faction plugin for PocketMine-MP
 * This file is part of FactionMaster
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @author ShockedPlot7560
 * @link https://github.com/ShockedPlot7560
 *
 *
*/

namespace ShockedPlot7560\FactionMasterBank\Button\Collection;

use pocketmine\player\Player;
use ShockedPlot7560\FactionMaster\Button\Back;
use ShockedPlot7560\FactionMaster\Button\Collection\Collection;
use ShockedPlot7560\FactionMaster\Database\Entity\UserEntity;
use ShockedPlot7560\FactionMaster\Route\RouterFactory;
use ShockedPlot7560\FactionMasterBank\Button\BankHistoryNext;
use ShockedPlot7560\FactionMasterBank\Button\BankHistoryPrevious;
use ShockedPlot7560\FactionMasterBank\Database\Entity\BankHistory as EntityBankHistory;
use ShockedPlot7560\FactionMasterBank\FactionMasterBank;
use ShockedPlot7560\FactionMasterBank\Route\BankHistory;
use function ceil;
use function count;

class HistoryBank extends Collection {
	const SLUG = "HistoryBank";

	/**
	 * @param EntityBankHistory[]
	 */
	public function __construct() {
		parent::__construct(self::SLUG);
		$this->registerCallable(self::SLUG, function(Player $player, UserEntity $user, array $results, int $currentPage = 1) {
			if ($currentPage > 1) {
				$this->register(new BankHistoryPrevious($currentPage));
			}
			$maxPage = ceil(count($results) / FactionMasterBank::getInstance()->getConfig()->get("max-item-history"));
			if ($currentPage < $maxPage) {
				$this->register(new BankHistoryNext($currentPage));
			}
			$this->register(new Back(RouterFactory::get(BankHistory::SLUG)->getBackRoute()));
		});
	}
}