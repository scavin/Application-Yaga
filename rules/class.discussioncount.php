<?php if(!defined('APPLICATION')) exit();
include_once 'interface.yagarule.php';
/**
 * This rule awards badges based on a user's join date
 *
 * @author Zachary Doll
 * @since 1.0
 * @package Yaga
 */
class DiscussionCount implements YagaRule{
  
  public function Award($Sender, $User, $Criteria) {
    decho($User);
    
    $Result = FALSE;
    switch($Criteria->Comparison) {
      case 'gt':
        if($User->CountDiscussions > $Criteria->Target) {
          $Result = TRUE;
        }
        break;
      case 'lt':
        if($User->CountDiscussions < $Criteria->Target) {
          $Result = TRUE;
        }
        break;
      default:
      case 'gte':
        if($User->CountDiscussions >= $Criteria->Target) {
          $Result = TRUE;
        }
        break;
    }
    
    return $Result;
  }
  
  public function Form($Form) {
    $Comparisons = array(
        'gt' => 'more than:',
        'lt' => 'less than:',
        'gte' => 'more than or equal to:'        
    );
    
    $String = $Form->Label('Total comments', 'CommentCount');
    $String .= 'User has ';
    $String .= $Form->DropDown('Comparison', $Comparisons);
    $String .= $Form->Textbox('Target');
    $String .= ' discussions';
    
    return $String;
  }
  
  public function Hooks() {
    return array('DiscussionModel_AfterSaveDiscussion');
  }
  
  public function Description() {
    $Description = 'This rule checks a users discussion count against the criteria. It will return true once the user has as many or more than the given amount.';
    return $Description;
    
  }
  
  public function Name() {
    return 'Discussion Count Total';
  }
}

?>
