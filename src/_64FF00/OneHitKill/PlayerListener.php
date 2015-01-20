<?php

namespace _64FF00\OneHitKill;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\Player;

class PlayerListener implements Listener
{
	public function __construct(OneHitKill $plugin)
	{
		$this->plugin = $plugin;
	}
	
	public function onPlayerDamage(EntityDamageEvent $event)
	{
		if($event instanceof EntityDamageByEntityEvent)
		{
			$damager = $event->getDamager();
			
			if($damager instanceof Player)
			{
				if($this->plugin->isAdded($damager)) 
				{
					$event->setDamage(PHP_INT_MAX);
				}
			}
		}
	}
}