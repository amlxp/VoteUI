<?php
/** Plugin By AmlxP Modz
 * Github: github.com\amlxp
 * Ok Thanks For See
 */

namespace VoteUI;

use pocketmine\plugin\PluginBase;
use pocketmine\Player; 
use pocketmine\Server;

use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;

use jojoe77777\FormApi;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener {
	
	public $plugin;

	public function onEnable(){
		$this->getLogger()->info("§aEnable Plugin VoteUI ");
		$this->getLogger()->info("Plugin by amlxp, Use the votereward that I made. Thanks");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
	}
	
	public function onCommand(CommandSender $sender, Command $command, String $label, array $args) : bool {
        switch($command->getName()){
            case "vote":
            $this->FormEco($sender);
            return true;
        }
        return true;
	}
	
	 public function FormEco($sender){
        $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createSimpleForm(function(Player $sender, $data){
          $result = $data;
          if($result === null){
          }
          switch($result){
              case 0:
              break;
              case 1:
              $command = "qwerty";
              $this->getServer()->getCommandMap()->dispatch($sender,$command);
              break;
          }
        });
        $config = $this->getConfig();
        $name = $sender->getName();
        $form->setTitle("§7- Vote -");
        $form->setContent("§7Hello players, §c{$name} §7Vote this server for get rewards");
        $form->addButton("§4EXIT\n§ftap to close");
		$form->addButton("§dVote Server\n§fGet Rewards");
        $form->sendToPlayer($sender);
	}
	
	public function MyMoney($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createSimpleForm(function(Player $player, $data){
			$result = $data[0];
			if($result === null){
			}
			switch($result){
			    case 0:
			    $this->FormEco($player);
			    break;
			}
		});
		$money = $this->eco->myMoney($player);
		$name = $player->getName();
		$form->setTitle("-");
		$form->setContent("-");
		$form->addButton("-");
		$form->sendToPlayer($player);
	}
	
	public function Pay($player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createCustomForm(function(Player $player, $result){
		    if($result === null){
            return;
            }
            if(trim($result[0]) === ""){
            $player->sendMessage("-");
            return;
            }
            if(trim($result[1]) === ""){
            $player->sendMessage("-");
            return;
            }
            $this->getServer()->getCommandMap()->dispatch($player, "pay ".$result[0]." ".$result[1]);
		});
		$form->setTitle("-");
		$form->addInput("-");
		$form->addInput("-");
		$form->sendToPlayer($player);
	}

	public function Poeple($player){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function(Player $player, ?array $data){
			if(!isset($data)) return;
			if($this->getServer()->getOfflinePlayer($data[0])->hasPlayedBefore() || $this->getServer()->getOfflinePlayer($data[0])->isOnline() && EconomyAPI::getInstance()->myMoney($data[0]) !== null){
				$this->MoneyPlayerForm($player, $data[0]);
			}else{
				$player->sendMessage("-");
			}
		});
		$form->setTitle("-");
		$form->addInput("-");
		$form->sendToPlayer($player);
	}

	public function MoneyPlayerForm(Player $player, string $target){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createCustomForm(function(Player $player, ?array $data){
		    
		});
		$uang = $this->eco->myMoney($target);
		$form->setTitle("-");
		$form->addLabel("-");
		$form->sendToPlayer($player);
	}
}
