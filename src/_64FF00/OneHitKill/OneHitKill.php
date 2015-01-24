<?php

namespace _64FF00\OneHitKill;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\TextFormat;

/*
      # #    #####  #       ####### #######   ###     ###   
      # #   #     # #    #  #       #        #   #   #   #  
    ####### #       #    #  #       #       #     # #     # 
      # #   ######  #    #  #####   #####   #     # #     # 
    ####### #     # ####### #       #       #     # #     # 
      # #   #     #      #  #       #        #   #   #   #  
      # #    #####       #  #       #         ###     ###                                        
                                                                                   
*/

class OneHitKill extends PluginBase
{
	private $players = [];
	
	public function onEnable()
	{
		$this->getServer()->getPluginManager()->registerEvents(new PlayerListener($this), $this);
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args)
	{
		if(!isset($args[0]))
		{
			$sender->sendMessage(TextFormat::BLUE . "[OneHitKill] Usage: /ohk <info / on / off>");
				
			return true;
		}
		
		switch(strtolower($args[0]))
		{
			case "info":
				
				$author = $this->getDescription()->getAuthors()[0];
				$version = $this->getDescription()->getVersion();
				
				if($sender instanceof ConsoleCommandSender)
				{
					$sender->sendMessage(TextFormat::BLUE . "[OneHitKill] You are currently using OneHitKill v$version by $author.");
				}
				else
				{
					$sender->sendMessage(TextFormat::BLUE . "[OneHitKill] This server is using OneHitKill v$version by $author.");
				}	
			
				break;
				
			case "on":
				
				if(!$sender instanceof Player)
				{
					$sender->sendMessage(TextFormat::BLUE . "[OneHitKill] This command can only be run from in-game.");
					
					break;
				}
				
				$this->addPlayer($sender);
				
				$sender->sendMessage(TextFormat::BLUE . "[OneHitKill] OneHitKill enabled.");
				
				break;
				
			case "off":
			
				if(!$sender instanceof Player)
				{
					$sender->sendMessage(TextFormat::BLUE . "[OneHitKill] This command can only be run from in-game.");
					
					break;
				}
				
				$this->removePlayer($sender);
				
				$sender->sendMessage(TextFormat::BLUE . "[OneHitKill] OneHitKill disabled.");
				
				break;
				
			default:
			
				$sender->sendMessage(TextFormat::BLUE . "[OneHitKill] Usage: /ohk <info / on / off>");
				
				break;
		}
		
		return true;
	}
	
	/*
	
			#    ######  ### ### 
		   # #   #     #  #  ### 
		  #   #  #     #  #  ### 
		 #     # ######   #   #  
		 ####### #        #      
		 #     # #        #  ### 
		 #     # #       ### ### 
	 
	 */    
	
	public function addPlayer(Player $player)
	{
		$this->players[] = $player->getName();
	}
	
	public function isAdded(Player $player)
	{
		return in_array($player->getName(), $this->players);
	}
	
	public function removePlayer(Player $player)
	{
		unset($this->players[$player->getName()]);
	}
}