<?php
namespace Admin;

class Cards
{
  private $cardSize;
  private $cardColor;
  private $cardTitle;
  private $cardSubTitle;
  private $cardMenu;
  private $cardMenuItems;
  private $cardBody;

  public function __construct()
  {
    $this->cardSize = "12";
    $this->cardColor = NULL;
    $this->cardMenu = false;
    $this->cardMenuItems = array();
    $this->cardBody = NULL;
  }
  public function set_card_size($cardSize)
  {
    $this->cardSize = $cardSize;
  }

  public function get_card_size()
  {
    return $this->cardSize;
  }

  public function set_card_color($cardColor)
  {
    $cardColor = " " . $cardColor;
    $this->cardColor = $cardColor;
  }

  public function get_card_color()
  {
    return $this->cardColor;
  }

  public function set_card_title($cardTitle)
  {
    $this->cardTitle = $cardTitle;
  }

  public function get_card_title()
  {
    return $this->cardTitle;
  }

  public function set_card_sub_title($cardSubTitle)
  {
    $this->cardSubTitle = $cardSubTitle;
  }

  public function get_card_sub_title()
  {
    return $this->cardSubTitle;
  }

  public function set_card_menu($cardMenu)
  {
    $this->cardMenu = $cardMenu;
  }

  public function add_card_menu_item(...$items)
  {
    $result = "";
    for($i = 0; $i < sizeof($items); $i++)
    {
    $result .= "<li>";
    $result .= $items[$i];
    $result .= "</li>";
    }

    array_push($this->cardMenuItems, $result);
  }

  public function get_card_menu_items()
  {
    return $this->cardMenuItems;
  }

  public function get_card_menu()
  {
    if ($this->cardMenu)
    {
      $result = "<ul class=\"header-dropdown m-r--5\">
            <li class=\"dropdown\">
                <a href=\"javascript:void(0);\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">
                    <i class=\"material-icons\">more_vert</i>
                </a>
                <ul class=\"dropdown-menu pull-right\">";
                    for ($i = 0; $i < sizeof($this->get_card_menu_items()); $i++)
                    {
                      $result.="<li>";
                      $result.= $this->get_card_menu_items()[$i];
                      $result.="</li>";
                    }
                $result .= "</ul>
            </li>
        </ul>";

    return $result;
    }
  }

  public function set_card_body(...$cardBody)
  {
    $result = "";
    for ($i = 0; $i < sizeof($cardBody); $i++)
    {
      $result .= $cardBody[$i];
    }

    $this->cardBody = $result;
  }

  public function get_card_body()
  {
    return $this->cardBody;
  }

  public function print_row(...$content)
  {
    $result = '<div class="row clearfix">';
    for($i = 0; $i < sizeof($content); $i++)
    {
      $result .= $this->print($content[$i]);
    }
    $result .= '</div>';

    return $result;
  }

  public function print($content = NULL)
  {
    $result = "\t" . ('<div class="col-lg-' . $this->get_card_size() . ' col-md-' . $this->get_card_size() * 2 . ' col-sm-' . $this->get_card_size() * 3 . ' col-xs-' . $this->get_card_size() * 4 . '">') . "\n";
    $result .= "\t" . ('<div class="card">');
    if ($this->get_card_title() || $this->get_card_menu())
    {
      $result .= "\t" . ('<div class="header' . $this->get_card_color() . '">') . "\n";
      $result .= "\t" . ('<h2>') . "\n";
      $result .= "\t" . ($this->get_card_title()) . "\n";
      $result .= "\t" . ('<small>' . $this->get_card_sub_title() . '</small>') . "\n";
      $result .= "\t" . ('</h2>') . "\n";
      $result .= "\t" . ($this->get_card_menu()) . "\n";
      $result .= "\t" . ('</div>') . "\n";
    }
    $result .= "\t" . ('<div class="body">') . "\n";
    $result .= "\t" . $content . "\n";
    $result .= "\t" . ('</div>') . "\n";
    $result .= "\t" . ('</div>') . "\n";
    $result .= "\t" . ('</div>') . "\n";

    return $result;
  }
}
?>
