<?php
namespace Admin;
use App;

class Forms
{
    private $action;
    private $name;
    private $method;
    private $rows;
    private $disabled_indexes;

    public function __construct()
    {
      $this->action = "";
      $this->method = "POST";
      $this->rows = array();
      $this->disabled_indexes = array();
    }

    public function set_name($name)
    {
      $this->name = $name;
    }

    public function get_name()
    {
      return $this->name;
    }

    public function set_action($action)
    {
      $this->action = $action;
    }

    public function get_action()
    {
      return $this->action;
    }

    public function set_method($method)
    {
      $this->method = $method;
    }

    public function get_method()
    {
      return $this->method;
    }

    public function add_disabled_index($index)
    {
      array_push($this->disabled_indexes,$index);
    }

    public function get_disabled_indexes()
    {
      return $this->disabled_indexes;
    }

    public function add_input_text(int $size = 2, $name = null, $label = null, $value = null, $help = NULL, $required = false, $permission = null)
    {
      $status = NULL;

      $size = "col-lg-" . $size . " col-md-" . $size * 2 . " col-sm-" . $size * 2 . "";

      switch ($required)
      {
        case true:
        $required = "required";
        break;

        default:
        $required = NULL;
        break;
      }

      if ($permission != NULL && !App\Permissions::valid($permission))
      {
        $this->add_disabled_index($name);
        $name = NULL;
        $status = "disabled";
      }

      $result =
      "<div class=\"{$size}\">
            <div class=\"form-group form-float\">
                <div class=\"form-line\">
                    <label class=\"form-label\">" . $label . "</label>
                    <input type=\"text\" id= \"" . $name . "\" name=\"" . $name . "\" value=\"" . $value . "\" class=\"form-control\" {$status} {$required}/>
                    <div class=\"help-info\">{$help}</div>
                </div>
            </div>
        </div>";

      return $result;
    }

    public function add_input_text_label(int $size = 2, $name = null, $label_before = null, $label_after = null, $value = null, $placeholder = NULL, $required = false, $permission = null)
    {
      $status = NULL;

      $size = "col-lg-" . $size . " col-md-" . $size * 2 . " col-sm-" . $size * 2 . "";

      switch ($required)
      {
        case true:
        $required = "required";
        break;

        default:
        $required = NULL;
        break;
      }

      if ($permission != NULL && !App\Permissions::valid($permission))
      {
        $this->add_disabled_index($name);
        $name = NULL;
        $status = "disabled";
      }

      $result =
      "<div class=\"{$size}\">
            <div class=\"input-group form-group form-float\">
            <span class=\"input-group-addon\">" . $label_before . "</span>
                <div class=\"form-line\">
                <select name=\"" . $name . "\" class=\"form-control show-tick\" {$required}>
                    <option value=\"\" {$status}>N/A</option>
                    </select>
                </div>
                <span class=\"input-group-addon\">" . $label_after . "</span>
            </div>
        </div>";

      return $result;
    }

    public function add_input_date($size = 2, $name = NULL, $label = NULL, $value = NULL, $help = NULL)
    {
      $size = "col-lg-" . $size . " col-md-" . $size * 2 . " col-sm-" . $size * 2 . "";

      $result =
      "<div class=\"{$size}\">
        <div class=\"form-group form-float\">
            <div class=\"form-line\" id=\"bs_datepicker_container\">
            <label class=\"form-label\">" . $label . "</label>
                <input type=\"text\" class=\"form-control\" name=\"{$name}\" value=\"{$value}\"placeholder=\"Please choose a date...\">
                <div class=\"help-info\">{$help}</div>
            </div>
        </div>
      </div>";

      return $result;
    }

    public function add_input_time($size = 2, $name = NULL, $label = NULL, $value = NULL, $help = NULL)
    {
      $size = "col-lg-" . $size . " col-md-" . $size * 2 . " col-sm-" . $size * 2 . "";

      $result =
      "<div class=\"{$size}\">
        <div class=\"form-group form-float\">
            <div class=\"form-line\">
            <label class=\"form-label\">" . $label . "</label>
                <input type=\"time\" class=\"form-control\" name=\"{$name}\" value=\"{$value}\"placeholder=\"Please choose a date...\">
                <div class=\"help-info\">{$help}</div>
            </div>
        </div>
      </div>";

      return $result;
    }

    public function add_select($name = null, array $value = array(), $current = NULL, $required = NULL, $permission = NULL, $help = NULL)
    {
      $status = NULL;

      switch ($required)
      {
        case true:
        $required = "required";
        break;

        default:
        $required = NULL;
        break;
      }

      if ($permission != NULL && !App\Permissions::valid($permission))
      {
        $this->add_disabled_index($name);
        $name = NULL;
        $status = "disabled";
      }

      $result=
      "<div id=\"" . $name . "_div\" class=\"col-lg-3 col-md-4 col-sm-4\">
            <select id=\"" . $name . "_select\" name=\"" . $name . "\" class=\"form-control show-tick\" {$required}>
                <option value=\"\" {$status}>N/A</option>";

        for($i = 0; $i < sizeof($value); $i++)
        {
            $array = explode("%", $value[$i]);
            $val = $array[0];
            $text = $array[1];

            switch($val)
            {
              case $current:
                $selected = "selected";
              break;

              default:
                $selected = NULL;
              break;
            }
            $result .= html_entity_decode("\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<option {$status} value=\"" . $val . "\" {$selected}>" . $text . "</option>");
        }

        $result .=
        "\n\t</select>
        <div class=\"help-info\">{$help}</div>
        </div>";
        return $result;
    }

    function add_select_multiple($name = null, array $value = array(), $current = NULL, $title = NULL, $required = NULL, $permission = NULL,)
    {
      $status = NULL;

      switch ($required)
      {
        case true:
        $required = "required";
        break;

        default:
        $required = NULL;
        break;
      }

      if ($permission != NULL && !App\Permissions::valid($permission))
      {
        $this->add_disabled_index($name);
        $name = NULL;
        $status = "disabled";
      }

      $result=
      "<div id=\"" . $name . "_div\" class=\"col-lg-12 col-md-12 col-sm-12\">
            <select title=\"$title\" id=\"" . $name . "_select\" name=\"" . $name . "\" class=\"form-control show-tick\" data-live-search=\"true\" data-selected-text-format=\"count\" tabindex=\"-98\" multiple {$required}>
                <option value=\"\" {$status}>N/A</option>";

        for($i = 0; $i < sizeof($value); $i++)
        {
            $array = explode("%", $value[$i]);
            $val = $array[0];
            $text = $array[1];

            if (in_array($val, $current))
            {
              $selected = "selected";
            } else {
              $selected = "null";
            }
            $result .= html_entity_decode("\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<option {$status} value=\"" . $val . "\" {$selected}>" . $text . "</option>");
        }

        $result .=
        "\n\t</select>
        </div>";
        return $result;
    }

    public function add_select_size($size = null, $name = null, array $value = array(), $current = NULL, $required = NULL, $permission = NULL, $help = NULL)
    {

      $status = NULL;
      $size = "col-lg-" . $size . " col-md-" . $size * 2 . " col-sm-" . $size * 2 . "";

      switch ($required)
      {
        case true:
        $required = "required";
        break;

        default:
        $required = NULL;
        break;
      }

      if ($permission != NULL && !App\Permissions::valid($permission))
      {
        $this->add_disabled_index($name);
        $name = NULL;
        $status = "disabled";
      }

      $result=
      "<div id=\"" . $name . "_div\" class=\"{$size}\">
            <select id=\"" . $name . "_select\" name=\"" . $name . "\" class=\"form-control show-tick\" {$required}>
                <option value=\"\" {$status}>N/A</option>";

        for($i = 0; $i < sizeof($value); $i++)
        {
            $array = explode("%", $value[$i]);
            $val = $array[0];
            $text = $array[1];

            switch($val)
            {
              case $current:
                $selected = "selected";
              break;

              default:
                $selected = NULL;
              break;
            }
            $result .= html_entity_decode("\n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<option {$status} value=\"" . $val . "\" {$selected}>" . $text . "</option>");
        }

        $result .=
        "\n\t</select>
        <div class=\"help-info\">{$help}</div>
        </div>";

        return $result;
    }

    public function add_button($content, $path = null, $name = null, $value = null)
    {
      $result =
      "<button form=\"generate\" value=\"" . $value . "\" name=\"" . $name . "\" type=\"submit\" class=\"btn btn-warning waves-effect\" href='" .$path . "'>" . strtoupper($content) . "</button>
       ";

      return $result;
    }

    public function add_input_submit($name = "submit", $value = "SUBMIT", $color = "bg-brown", int $size = 12, $permission = NULL)
    {

      $status = NULL;

      if ($permission != NULL && !App\Permissions::valid($permission))
      {
        $this->add_disabled_index($name);
        $name = NULL;
        $status = "disabled";
      }

      $size = "col-lg-" . $size . " col-md-" . $size * 2 . " col-sm-" . $size * 2 . "";

      $result =
      "<div class=\"{$size}\">
            <button class=\"btn btn-block btn-lg {$color} waves-effect\" type=\"submit\" name=\"" . $name . "\" {$status}>" . $value . "</button>
       </div>";

       return $result;
    }

    public function add_input_submit_confirm($name = "submit", $value = "SUBMIT", $color = "bg-brown", int $size = 12, $permission = NULL)
    {

      $status = NULL;

      if ($permission != NULL && !App\Permissions::valid($permission))
      {
        $this->add_disabled_index($name);
        $name = NULL;
        $status = "disabled";
      }

      $size = "col-lg-" . $size . " col-md-" . $size * 2 . " col-sm-" . $size * 2 . "";

      $result =
      "<div class=\"{$size}\">
            <button class=\"btn btn-block btn-lg {$color} waves-effect\" type=\"submit\" name=\"" . $name . "\" {$status}>" . $value . "</button>
       </div>";

       return $result;
    }

    public function add_row($header = "Header", $permission = null, ...$content)
    {
      $result = "";
      if (isset($header))
      {
        $result .= "\t" . "<b><h5>" . ($header) . "</h5></b>" . "\n";
      }
      $result .= "\t" . "<div class=\"row clearfix\">" . "\n";
      for($i = 0; $i < sizeof($content); $i++)
      {
        $result .= "\t" . $content[$i] . "\n";
      }
      $result .= "\t" . "</div>" . "\n";

      if ($permission == NULL || App\Permissions::valid($permission))
      {
      array_push($this->rows, $result);
      }
    }

    public function get_rows()
    {
      return $this->rows;
    }

    public function print()
    {

      $result = "";
      $result.= "\t" . "<form id=\"" . $this->get_name() . "\" action=\"" . $this->get_action() ."\" method=\"" . $this->get_method() ."\">" . "\n";
      for ($i = 0; $i < sizeof($this->get_rows()); $i++)
      {
        $result .= "\t" . $this->get_rows()[$i] . "\n";
      }
      $result.= "\t" . "</form>" . "\n";
      return $result;
    }
}
?>
